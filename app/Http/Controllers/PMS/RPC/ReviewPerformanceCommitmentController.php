<?php

namespace App\Http\Controllers\PMS\RPC;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PMS\PCR\CoreFunctionController;
use App\Models\PMS\PCR\PmsPcrStatus;
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


        return Inertia("PMS/RPC/ReviewPerformanceCommitmentAndReviewForm", ["period" => $period, "pms_pcr_status" => $pms_pcr_status]);
    }
}
