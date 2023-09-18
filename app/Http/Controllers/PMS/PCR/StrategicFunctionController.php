<?php

namespace App\Http\Controllers\PMS\PCR;

use App\Http\Controllers\Controller;
use App\Models\PMS\PCR\PmsPcrStrategicFunctionData;
use App\Models\PMS\PmsPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class StrategicFunctionController extends Controller
{
    public function show($period_id, $status_id)
    {
        $period = PmsPeriod::find($period_id);
        $rows = PmsPcrStrategicFunctionData::where("pms_period_id", $period_id)->where("sys_employee_id", auth()->user()->sys_employee_id)->get();
        return Inertia::render("Pms/Pcr/StrategicFunction", ["period" => $period, "rows" => $rows]);
    }

    public function create_update($period_id, $status_id, Request $request)
    {
        if (!$request->id) {
            $strat = new PmsPcrStrategicFunctionData();
            $strat->pms_period_id = $period_id;
            $strat->sys_employee_id = auth()->user()->sys_employee_id;
            $strat->function_title = $request->function_title;
            $strat->success_indicator = $request->success_indicator;
            $strat->actual_accomplishment = $request->actual_accomplishment;
            $strat->final_numerical_rating = $request->final_numerical_rating;
            $strat->percent = 20; //$request->percent;
            $strat->remarks = null;
            $strat->not_applicable = false;
        } else {
            $id = $request->id;
            $strat = PmsPcrStrategicFunctionData::find($id);
            // $strat->pms_period_id = $period_id;
            // $strat->sys_employee_id = auth()->user()->sys_employee_id;
            $strat->function_title = $request->function_title;
            $strat->success_indicator = $request->success_indicator;
            $strat->actual_accomplishment = $request->actual_accomplishment;
            $strat->final_numerical_rating = $request->final_numerical_rating;
            $strat->percent = 20; //$request->percent;
            $strat->remarks = null;
            $strat->not_applicable = false;
        }
        $strat->save();
        return Redirect::back();
    }

    public function delete($period_id, $status_id, $strat_id)
    {
        $strat = PmsPcrStrategicFunctionData::find($strat_id);
        $strat->delete();
        return Redirect::back();
    }
}
