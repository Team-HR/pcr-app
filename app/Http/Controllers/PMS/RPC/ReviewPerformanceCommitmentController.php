<?php

namespace App\Http\Controllers\PMS\RPC;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PMS\PCR\CoreFunctionController;
use App\Http\Controllers\PMS\PCR\SupportFunctionController;
use App\Models\PMS\PCR\PmsPcrCoreFunctionData;
use App\Models\PMS\PCR\PmsPcrCoreFunctionDataHistory;
use App\Models\PMS\PCR\PmsPcrStatus;
use App\Models\PMS\PCR\PmsPcrStrategicFunctionData;
use App\Models\PMS\PmsPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ReviewPerformanceCommitmentController extends Controller
{
    public function index()
    {
        $periods = PmsPeriod::all();
        foreach ($periods as $key => $period) {
            $periods[$key]['text'] = $period['period'] . ", " . $period['year'];
        }

        return Inertia("PMS/RPC/Index", ["periods" => $periods]);
    }

    public function get_recommendations($pms_pcr_status_id)
    {
        $file = PmsPcrStatus::find($pms_pcr_status_id);
        // $file->recommendations = $request->recommendations;
        return $file->recommendations;
    }

    /*
     function save_corrections 
     saves previous core_function_data to core_function_data_history table 
     and new corrections to core_function_data table
    */



    public function save_corrections($pms_pcr_status_id, Request $request)
    {
        // return $request;      
        $auth_id = Auth()->user()->id;
        # check if changes were made
        $changes = [
            'actual' => false,
            'quality' => false,
            'efficiency' => false,
            'timeliness' => false,
            'percent' => false,
            'remarks' => false,
        ];

        $changes_were_made = false;

        foreach ($changes as $key => $value) {
            if ($request->previous[$key] != $request->new[$key]) {
                $changes[$key] = true;
                if ($changes_were_made != true) {
                    $changes_were_made = true;
                }
            }
        }

        # if none return false
        // if (!$changes_were_made) return json_encode(false);
        # if exists store changes
        # save previous to history table
        # and save new to data table

        save_to_pms_pcr_core_function_data($request->new, $changes);
        $previous = $request->previous;
        save_to_pms_pcr_core_function_data_histories($previous);
        // return $previous;
        // return $request;
        return json_encode($changes_were_made);
    }

    public function save_recommendations($pms_pcr_status_id, Request $request)
    {
        $file = PmsPcrStatus::find($pms_pcr_status_id);
        $file->recommendations = $request->recommendations;
        $file->save();
    }

    public function revert($pms_pcr_status_id)
    {
        $file = PmsPcrStatus::find($pms_pcr_status_id);
        $file->is_submitted = 0;
        $file->save();
    }


    public function show($period_id)
    {
        $period = PmsPeriod::find($period_id);
        $items = [];
        $auth_sys_employee_id = auth()->user()->sys_employee_id;
        $items = PmsPcrStatus::where('immediate_supervisor', $auth_sys_employee_id)->where('pms_period_id', $period_id)->get();
        return Inertia("PMS/RPC/ReviewPerformanceCommitmentAndReview", ["period" => $period, "items" => $items]);
    }



    public function showPcr($pms_pcr_status_id)
    {
        $pms_pcr_status = PmsPcrStatus::find($pms_pcr_status_id);
        $pms_period_id = $pms_pcr_status["pms_period_id"];
        $period = PmsPeriod::find($pms_period_id);

        $strategic_function = PmsPcrStrategicFunctionData::where('pms_period_id', $pms_period_id)->where('sys_employee_id', $pms_pcr_status->sys_employee_id)->first();
        $core_functions = new CoreFunctionController;
        $core_functions = $core_functions->get_row_data($pms_period_id, $pms_pcr_status_id, $pms_pcr_status->sys_employee_id);
        $core_functions = $core_functions;
        $support_function = new SupportFunctionController();
        $support_functions = $support_function->get_support_function_rows($pms_pcr_status->sys_employee_id, $pms_period_id);
        $support_functions = $support_functions;
        // return $support_function;

        $data =  [
            "period" => $period,
            "form_status" => $pms_pcr_status,
            "strategic_function" =>  $strategic_function,
            "core_functions" => $core_functions,
            "support_functions" => $support_functions
        ];

        return Inertia("PMS/RPC/ReviewPerformanceCommitmentAndReviewForm", $data);
        // return Inertia::render("PMS/RPC/Print", [
        //     "form_status" => $pms_pcr_status,
        //     "strategic_function" =>  $strategic_function,
        //     "core_functions" => $core_functions,
        //     "support_functions" => $support_functions
        // ]);
    }
}


function save_to_pms_pcr_core_function_data_histories($previous)
{
    $pms_pcr_core_function_data_histories = new PmsPcrCoreFunctionDataHistory();
    $pms_pcr_core_function_data_histories->pms_pcr_core_function_data_id = $previous['id'];
    $pms_pcr_core_function_data_histories->actual = $previous['actual'];
    $pms_pcr_core_function_data_histories->quality = $previous['quality'];
    $pms_pcr_core_function_data_histories->efficiency = $previous['efficiency'];
    $pms_pcr_core_function_data_histories->timeliness = $previous['timeliness'];
    $pms_pcr_core_function_data_histories->percent = $previous['percent'];
    $pms_pcr_core_function_data_histories->remarks = $previous['remarks'];
    $pms_pcr_core_function_data_histories->not_applicable = $previous['not_applicable'];
    $pms_pcr_core_function_data_histories->changes = $previous['changes'];
    $pms_pcr_core_function_data_histories->not_applicable_remarks = $previous['not_applicable_remarks'];
    $pms_pcr_core_function_data_histories->created_by_sys_employee_id = $previous['created_by_sys_employee_id'];
    $pms_pcr_core_function_data_histories->created_by_type = $previous['created_by_type'];
    $pms_pcr_core_function_data_histories->save();
}


function save_to_pms_pcr_core_function_data($new, $changes)
{
    $accomplishment_data = PmsPcrCoreFunctionData::find($new['id']);
    $accomplishment_data->pms_rsm_success_indicator_id = $new['pms_rsm_success_indicator_id'];
    $accomplishment_data->pms_period_id = $new['pms_period_id'];
    $accomplishment_data->sys_employee_id = $new['sys_employee_id'];
    $accomplishment_data->actual = $new['actual'];
    $accomplishment_data->quality = $new['quality'];
    $accomplishment_data->efficiency = $new['efficiency'];
    $accomplishment_data->timeliness = $new['timeliness'];
    $accomplishment_data->percent = $new['percent'];
    $accomplishment_data->remarks = $new['remarks'];
    $accomplishment_data->not_applicable = $new['not_applicable'] ? true : false;
    $accomplishment_data->changes = json_encode($changes);
    $accomplishment_data->created_by_sys_employee_id = auth()->user()->sys_employee_id;
    $accomplishment_data->created_by_type = 'sup';
    $accomplishment_data->save();
}
