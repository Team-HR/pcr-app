<?php

namespace App\Http\Controllers\PMS\PCR;

use App\Http\Controllers\Controller;
// use App\Http\Controllers\PMS\PCR\CoreFunctionController;
use App\Models\SysEmployee;
use App\Models\PMS\PCR\PmsPcrStatus;
use App\Models\PMS\PmsPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use App\Http\Controllers\PMS\PCR\SupportFunctionController;
use App\Models\PMS\PCR\PmsPcrStrategicFunctionData;
use App\Http\Controllers\PMS\PCR\CoreFunctionController;

class PcrController extends Controller
{
    public function index()
    {
        $periods = PmsPeriod::all();
        foreach ($periods as $key => $period) {
            $periods[$key]['text'] = $period['period'] . ", " . $period['year'];
        }
        return Inertia::render("PMS/PCR/Index", ["periods" => $periods]);
    }

    public function submit($period_id, Request $request)
    {
        $id = $request->id;
        $overall_numerical_rating = $request->overall_numerical_rating;


        $update = PmsPcrStatus::where('id', $id)
            ->update([
                'is_submitted' => 1,
                'date_accomplished' => date("Y-m-d"),
                'overall_numerical_rating' => $overall_numerical_rating
            ]);
        //     Flight::where('active', 1)
        //   ->where('destination', 'San Diego')
        //   ->update(['delayed' => 1]);


        return Redirect::back();
        // return $update;
        // return Inertia::render("Pms/Pcr/Index", ["periods" => $periods]);
    }

    public function show($period_id)
    {
        $period = PmsPeriod::find($period_id);
        $sys_employee_id = auth()->user()->sys_employee_id;
        # get pms_performance_committment_review_status
        $form_status = PmsPcrStatus::where("pms_period_id", $period_id)->where("sys_employee_id", $sys_employee_id)->first();
        # if none create
        if (!$form_status) {
            $sys_employee_id = auth()->user()->sys_employee_id;
            $sys_department_id = auth()->user()->sys_department_id;
            $form = new PmsPcrStatus;
            $form->pms_period_id = $period_id;
            $form->sys_employee_id = $sys_employee_id;
            $form->sys_department_id = $sys_department_id;
            $form->save();
            $form_status = PmsPcrStatus::find($form->id);
        }

        $core_function = new CoreFunctionController;
        $data = $core_function->get_row_data($period_id, $form_status->id, $sys_employee_id);
        $form_status["total_percentage_weight"] = isset($data["total_percentage_weight"]) ? $data["total_percentage_weight"] : 0;
        $form_status["total_average_rating"] = isset($data["total_average_rating"]) ? $data["total_average_rating"] : 0;
        $form_status["strat_total_percentage_weight"] = isset($data["strat_total_percentage_weight"]) ? $data["strat_total_percentage_weight"] : 0;
        $form_status["strat_total_average_rating"] = isset($data["strat_total_average_rating"]) ? $data["strat_total_average_rating"] : 0;
        $support_function_controller = new SupportFunctionController();
        $support_function_data = $support_function_controller->get_support_function_rows($sys_employee_id, $period_id);
        $form_status["support_total_percentage_weight"] = $support_function_data["total_percentage_weight"];
        $form_status["support_total_average_rating"] =  $support_function_data["total_numerical_rating"];

        $form_status["overall_percentage_weight"] = $form_status["total_percentage_weight"] +
            $form_status["strat_total_percentage_weight"] +
            $form_status["support_total_percentage_weight"];
        $form_status["overall_numerical_rating"] = bcdiv($form_status["total_average_rating"] +
            $form_status["strat_total_average_rating"] +
            $form_status["support_total_average_rating"], 1, 2);

        return Inertia::render("Pms/Pcr/Form", ["period" => $period, "form_status" => $form_status]);
    }

    public function show_form_type($period_id, $id)
    {
        $period = PmsPeriod::find($period_id);
        $form_type = PmsPcrStatus::find($id);
        return Inertia::render("Pms/Pcr/FormType", ["period" => $period, "form_type" => $form_type]);
    }

    public function set_form_type($period_id, $id, Request $request)
    {
        $period = PmsPeriod::find($period_id);
        $form = PmsPcrStatus::find($id);
        $agency_current =  $form->agency;
        $agency_new =  $request->agency;
        $form->agency = $request->agency;
        $form->form_type = $request->form_type;

        if ($agency_current != $agency_new) {
            $form->immediate_supervisor = null;
            $form->department_head = null;
            $form->head_of_agency = null;
        }
        $form->save();
        return Redirect::back();
    }

    public function show_signatories($period_id, $id)
    {
        $period = PmsPeriod::find($period_id);
        $employees = SysEmployee::orderBy('last_name')->get()->toArray();
        $form_type = PmsPcrStatus::find($id);
        return Inertia::render("Pms/Pcr/Signatories", ["period" => $period, "form_type" => $form_type, "employees" => $employees]);
    }

    public function set_signatories($period_id, $id, Request $request)
    {
        $period = PmsPeriod::find($period_id);
        $form = PmsPcrStatus::find($id);

        // if (isset($request->immediate_supervisor)) {
        // }

        if ($form->agency == "nga") {
            $form->immediate_supervisor = mb_convert_case($request->immediate_supervisor, MB_CASE_UPPER);
            $form->department_head = mb_convert_case($request->department_head, MB_CASE_UPPER);
        } else {
            $id = isset($request->immediate_supervisor) ? $request->immediate_supervisor["id"] : null;
            $form->immediate_supervisor = $id;
            $id = isset($request->department_head) ? $request->department_head["id"] : null;
            $form->department_head = $id;
        }
        $form->head_of_agency = isset($request->head_of_agency) ? mb_convert_case($request->head_of_agency, MB_CASE_UPPER) : NULL;
        $form->save();
        return Redirect::back();
    }

    public function print($period_id, $form_status_id)
    {
        // return $form_status;
        $form_status = PmsPcrStatus::find($form_status_id);
        $strategic_function = PmsPcrStrategicFunctionData::where('pms_period_id', $period_id)->where('sys_employee_id', $form_status->sys_employee_id)->first();
        $core_functions = new CoreFunctionController;
        $core_functions = $core_functions->get_row_data($period_id, $form_status_id, $form_status->sys_employee_id);
        $core_functions = $core_functions;
        $support_function = new SupportFunctionController();
        $support_functions = $support_function->get_support_function_rows($form_status->sys_employee_id, $period_id);
        $support_functions = $support_functions;
        // return $support_function;

        return Inertia::render("Pms/Pcr/Print", [
            "form_status" => $form_status,
            "strategic_function" =>  $strategic_function,
            "core_functions" => $core_functions,
            "support_functions" => $support_functions
        ]);
    }
}
