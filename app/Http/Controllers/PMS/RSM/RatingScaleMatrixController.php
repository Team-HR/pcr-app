<?php

namespace App\Http\Controllers\PMS\RSM;

use App\Http\Controllers\Controller;
use App\Models\PMS\PmsPeriod;
use App\Models\PMS\RSM\PmsRsm;
use App\Models\PMS\RSM\PmsRsmAssignment;
use App\Models\PMS\RSM\PmsRsmSuccessIndicator;
use App\Models\SysEmployee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class RatingScaleMatrixController extends Controller
{
    public function index()
    {
        $periods = PmsPeriod::all();
        foreach ($periods as $key => $period) {
            $periods[$key]['text'] = $period['period'] . ", " . $period['year'];
        }

        $parents = [];

        return Inertia::render('PMS/RSM/Index', ['periods' => $periods]);
    }

    public function show($period_id)
    {

        $sys_department_id = auth()->user()->sys_department_id;
        $rows = [];

        $pms_rating_scale_matrices = PmsRsm::where('period_id', $period_id)
            ->where('sys_department_id', $sys_department_id)
            ->where('parent_id', null)
            ->orderBy('code')
            ->get();

        # sort parents first start -- according to the alphanumeric code
        $sorted_codes = [];
        foreach ($pms_rating_scale_matrices as $key => $mfo) {
            $sorted_codes[] = $mfo["code"];
        }
        natsort($sorted_codes);
        $sorted_pms_rating_scale_matrices = [];
        foreach ($sorted_codes as $code) {
            foreach ($pms_rating_scale_matrices as $mfo) {
                if ($mfo["code"] == $code) {
                    $sorted_pms_rating_scale_matrices[] = $mfo;
                    continue;
                }
            }
        }
        # sort end

        // return $sorted_pms_rating_scale_matrices;
        // return $pms_rating_scale_matrices;
        $matrices = [];
        foreach ($pms_rating_scale_matrices as $key => $mfo) {
            $matrices[] = $mfo;
            # check if mfo has children
            $matrices = get_mfo_children($matrices, $mfo["id"]);
        }

        // return $matrices;

        foreach ($matrices as $row) {
            $level = get_level(0, $row["parent_id"]);
            $rowspan = 0;
            $si_only = false;
            $success_indicators = get_success_indicators($row["id"]);
            $success_indicators_count = count($success_indicators);
            $rowspan = $success_indicators_count > 1 ? $success_indicators_count : 0;
            $datum = [
                "id" => $row["id"],
                "parent_id" => $row["parent_id"],
                "level" => $level,
                "rowspan" => $rowspan,
                "mfo_only" => true,
                "si_only" => $si_only,
                "code" => $row["code"],
                "title" => $row["title"],
            ];

            # if no success indicators
            if ($success_indicators_count < 1) {
                $rows[] = $datum;
            } else {
                # if there is/are success indicators
                $datum["mfo_only"] = false;
                foreach ($success_indicators as $key => $success_indicator) {
                    if ($key > 0) {
                        $datum["si_only"] = true;
                    }

                    $quality = $success_indicator["quality"];
                    $efficiency = $success_indicator["efficiency"];
                    $timeliness = $success_indicator["timeliness"];

                    $performance_measures = [];

                    if ($quality) {
                        $performance_measures[] = "Quality";
                    }
                    if ($efficiency) {
                        $performance_measures[] = "Efficiency";
                    }
                    if ($timeliness) {
                        $performance_measures[] = "Timeliness";
                    }

                    $in_charges = PmsRsmAssignment::where("pms_rsm_success_indicator_id", $success_indicator["id"])->get();

                    $success_indicator_datum = [
                        "success_indicator_id" => $success_indicator["id"],
                        "success_indicator" => $success_indicator["success_indicator"],
                        "performance_measures" => $performance_measures,
                        "quality" => $quality,
                        "efficiency" => $efficiency,
                        "timeliness" => $timeliness,
                        "in_charges" => get_incharges($in_charges)
                    ];
                    $rows[] = array_merge($datum, $success_indicator_datum);
                }
            }
        }

        // return $rows;
        $parents = $matrices;
        foreach ($parents as $key => $parent) {
            $parents[$key]["label"] = $parent["code"] . ")  " . $parent["title"];
        }

        $period = PmsPeriod::find($period_id);

        return Inertia::render('PMS/RSM/RatingScaleMatrix', ['period' => $period, 'period_id' => $period_id, 'rows' => $rows, 'parents' => $parents]);
    }

    public function create($period_id, Request $request)
    {
        $sys_department_id = auth()->user()->sys_department_id;
        if (!$sys_department_id) return "error: no assigned department!";
        $mfo = new PmsRsm;
        $mfo->period_id = $period_id;
        $mfo->parent_id = $request->parent_id;
        $mfo->sys_department_id = $sys_department_id;
        $mfo->code = $request->code;
        $mfo->title = $request->title;
        $mfo->save();
        return Redirect::back();
    }

    public function update($period_id, Request $request)
    {
        $mfo = PmsRsm::find($request->id);
        $mfo->parent_id = $request->parent_id;
        $mfo->code = $request->code;
        $mfo->title = $request->title;
        $mfo->save();

        return Redirect::back();
    }

    public function destroy($period_id, $id)
    {
        # defined for pms_rsm_success_indicators deletion and pms_rsm_assignments
        $pms_rsm_success_indicators = [];

        # get mfo children
        $children = [];
        $children =  get_mfo_children($children, $id);

        # delete mfo children
        foreach ($children as $child) {
            if ($pms_rsm_success_indicator = PmsRsmSuccessIndicator::where("pms_rsm_id", $child["id"])->get()->toArray()) {
                $pms_rsm_success_indicators[] = $pms_rsm_success_indicator;
            };
            PmsRsm::find($child["id"])->delete(); // uncomment after testing
        }

        # delete parent mfo
        $mfo = PmsRsm::find($id);
        $mfo->delete(); // uncomment after testing

        if ($pms_rsm_success_indicator = PmsRsmSuccessIndicator::where("pms_rsm_id", $child["id"])->get()->toArray()) {
            $pms_rsm_success_indicators[] = $pms_rsm_success_indicator;
        };

        $merged_pms_rsm_success_indicators = [];

        foreach ($pms_rsm_success_indicators as $key => $array) {
            $merged_pms_rsm_success_indicators = array_merge($merged_pms_rsm_success_indicators, $array);
        }

        $si_to_be_deleted = [];

        foreach ($merged_pms_rsm_success_indicators as $si) {
            if (!in_array($si["id"], $si_to_be_deleted)) {
                $si_to_be_deleted[] = $si["id"];
            }
        }

        foreach ($si_to_be_deleted as $pms_rsm_success_indicator_id) {
            $SI = new SuccessIndicatorController();
            $SI->delete($pms_rsm_success_indicator_id);
        }

        return Redirect::back();
    }
}


# get mfo children
function get_mfo_children($matrices, $parent_id)
{
    $children = PmsRsm::where("parent_id", $parent_id)->orderBy("code")->get()->toArray();

    # sort parents first start -- according to the alphanumeric code
    $sorted_codes = [];
    foreach ($children as $key => $mfo) {
        $sorted_codes[] = $mfo["code"];
    }

    natsort($sorted_codes);

    $sorted_children = [];
    foreach ($sorted_codes as $code) {
        foreach ($children as $mfo) {
            if ($mfo["code"] == $code) {
                $sorted_children[] = $mfo;
                continue;
            }
        }
    }

    # sort end
    foreach ($sorted_children as $key => $child) {
        $matrices[] =  $child;
        $matrices = get_mfo_children($matrices, $child["id"]);
    }
    return $matrices;
}

# get level iterator
function get_level($level = 0, $parent_id)
{
    $rsm = PmsRsm::find($parent_id);
    if ($rsm) {
        $level = $level + 1;
        $level = get_level($level, $rsm["parent_id"]);
    }
    return $level;
}

# count rowspan 
function get_rowspan($id)
{
    $count = PmsRsmSuccessIndicator::where("pms_rsm_id", $id)->count();
    return $count;
}

# get success indicators of the mfo/pap
function get_success_indicators($id)
{
    $pms_rating_scale_matrix_success_indicators = PmsRsmSuccessIndicator::where("pms_rsm_id", $id)->get();
    return $pms_rating_scale_matrix_success_indicators;
}

# get in-charge employees
function get_incharges($assignments)
{
    $data = [];
    if (!$assignments) return $data;
    foreach ($assignments as $key => $assignment) {
        $sys_employee = SysEmployee::find($assignment->sys_employee_id);
        // $datum = 
        $data[] = [
            "id" => $sys_employee->id,
            "full_name" => $sys_employee->full_name,
        ];
    }

    return $data;
}
