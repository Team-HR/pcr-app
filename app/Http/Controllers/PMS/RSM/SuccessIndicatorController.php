<?php

namespace App\Http\Controllers\PMS\RSM;

use App\Http\Controllers\Controller;
use App\Models\PMS\RSM\PmsRsm;
use App\Models\PMS\RSM\PmsRsmAssignment;
use App\Models\PMS\RSM\PmsRsmSuccessIndicator;
use App\Models\SysEmployee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class SuccessIndicatorController extends Controller
{
    public function index($period_id, $rsm_id)
    {
        // $periods = PmsPeriod::all();
        // foreach ($periods as $key => $period) {
        //     $periods[$key]['text'] = $period['period'] . ", " . $period['year'];
        // }

        // $parents = [];
        $mfo = PmsRsm::find($rsm_id);
        $sys_employees = SysEmployee::orderBy('last_name')->get();
        $success_indicators = [];
        return Inertia::render("PMS/RSM/SuccessIndicator", ["employees" => $sys_employees, "mfo" => $mfo, "success_indicators" => $success_indicators]);
    }

    public function create($period_id, $rsm_id, Request $request)
    {
        $success_indicator = new PmsRsmSuccessIndicator;
        $success_indicator->pms_rsm_id = $rsm_id;
        $success_indicator->index = 0;
        $success_indicator->success_indicator = $request->success_indicator;
        $success_indicator->quality = $request->quality;
        $success_indicator->efficiency = $request->efficiency;
        $success_indicator->timeliness = $request->timeliness;
        $success_indicator->save();
        $pms_rsm_success_indicator_id = $success_indicator->id;
        if (isset($request->in_charges)) {
            foreach ($request->in_charges as $emp) {
                $assignment = new PmsRsmAssignment;
                $assignment->period_id = $period_id;
                $assignment->pms_rsm_success_indicator_id = $pms_rsm_success_indicator_id;
                $assignment->sys_employee_id = $emp["id"];
                $assignment->save();
            }
        }

        return Redirect::back(303);
    }

    public function edit($period_id, $rsm_id, $id)
    {
        $mfo = PmsRsm::find($rsm_id);
        $success_indicator = PmsRsmSuccessIndicator::find($id);
        # get list of incharges
        $assignments = PmsRsmAssignment::where("pms_rsm_success_indicator_id", $success_indicator->id)->get();

        $in_charges = [];
        if ($assignments) {
            foreach ($assignments as $assignment) {
                $employee = SysEmployee::find($assignment["sys_employee_id"]);
                $in_charges[]  = $employee;
            }
        }

        $success_indicator["in_charges"] = $in_charges;

        $sys_employees = SysEmployee::orderBy('last_name')->get()->toArray();
        // return $sys_employees;
        foreach ($in_charges as $in_charge) {
            foreach ($sys_employees as $key => $sys_employee) {
                if ($sys_employee["id"] == $in_charge["id"]) {
                    array_splice($sys_employees, $key, 1);
                }
            }
        }

        return Inertia::render("PMS/RSM/SuccessIndicator", ["employees" => $sys_employees, "mfo" => $mfo, "success_indicator" => $success_indicator]);
    }

    public function update($period_id, $rsm_id, $id, Request $request)
    {
        $success_indicator = PmsRsmSuccessIndicator::find($request->id);
        $success_indicator->success_indicator = $request->success_indicator;
        $success_indicator->quality = $request->quality;
        $success_indicator->efficiency = $request->efficiency;
        $success_indicator->timeliness = $request->timeliness;
        $success_indicator->save();

        # delete all existing assignments of the success indicator
        $assignments = PmsRsmAssignment::where("pms_rsm_success_indicator_id", $request->id);
        $assignments->delete();

        if (isset($request->in_charges)) {
            foreach ($request->in_charges as $emp) {
                $assignment = new PmsRsmAssignment;
                $assignment->period_id = $period_id;
                $assignment->pms_rsm_success_indicator_id = $request->id;
                $assignment->sys_employee_id = $emp["id"];
                $assignment->save();
            }
        }

        // return Redirect::route("rsm.show", ["period_id" => $period_id]);
        return Redirect::back(303);
    }

    public function destroy($period_id, $rsm_id, $id)
    {
        // return $id;
        $success_indicator = PmsRsmSuccessIndicator::find($id);
        $success_indicator->delete();
        return Redirect::back();
    }
}
