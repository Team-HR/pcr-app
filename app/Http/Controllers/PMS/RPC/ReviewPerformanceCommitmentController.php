<?php

namespace App\Http\Controllers\PMS\RPC;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PMS\PCR\CoreFunctionController;
use App\Http\Controllers\PMS\PCR\SupportFunctionController;
use App\Models\PMS\PCR\PmsPcrStatus;
use App\Models\PMS\PCR\PmsPcrStrategicFunctionData;
use App\Models\PMS\PmsPeriod;
use Illuminate\Http\Request;
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
