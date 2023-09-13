<?php

namespace App\Http\Controllers\PMS\IRSM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\PMS\PmsPeriod;
use App\Models\PMS\RSM\PmsRsm;
use App\Models\PMS\RSM\PmsRsmAssignment;
use App\Models\PMS\RSM\PmsRsmSuccessIndicator;
use App\Models\SysEmployee;

class IndividualRatingScaleMatrixController extends Controller
{
    public function index()
    {
        $periods = PmsPeriod::all();
        foreach ($periods as $key => $period) {
            $periods[$key]['text'] = $period['period'] . ", " . $period['year'];
        }
        return Inertia::render("PMS/IRSM/Index", ["periods" => $periods]);
    }

    public function show($period_id)
    {
        // return json_encode(auth()->user());
        $period = PmsPeriod::find($period_id);
        $sys_employee_id = auth()->user()->sys_employee_id;

        $assignments = PmsRsmAssignment::where("period_id", $period_id)->where("sys_employee_id", $sys_employee_id)->get();

        # get the success indicator ids
        $success_indicator_ids = [];


        foreach ($assignments as $assignment) {
            $success_indicator_ids[] = $assignment->pms_rsm_success_indicator_id;
        }

        // return $success_indicator_ids;
        // return json_encode(PmsRsmSuccessIndicator::find(2));

        # get mfo ids
        $mfo_ids = [];
        foreach ($success_indicator_ids as $success_indicator_id) {
            $mfo = PmsRsmSuccessIndicator::find($success_indicator_id);
            if ($mfo) {
                $mfo_id = $mfo->pms_rsm_id;
                if (!in_array($mfo_id, $mfo_ids)) {
                    $mfo_ids[] = $mfo_id;
                }
            }
        }

        //  return $mfo_ids;

        // return $mfo_ids;
        # get mfo data and parents as well
        $mfos = [];

        // return $mfo_ids;

        foreach ($mfo_ids as $key => $mfo_id) {
            $mfo = PmsRsm::find($mfo_id);
            $mfos[] = $mfo;
            $mfos = get_parent($mfos, $mfo->parent_id);
        }

        $rows = GET_SORTED_RSM_ROWS($mfos);

        return Inertia::render("PMS/IRSM/IndividualRatingScaleMatrix", [
            "period" => $period, "rows" => $rows
        ]);
    }
}


function get_parent($mfos, $parent_id)
{
    // return $mfos;
    $mfo = PmsRsm::find($parent_id);
    if (!$mfo) return $mfos;

    // check if mfo is already on $mfos
    foreach ($mfos as $key => $item) {
        if ($item['id'] == $parent_id) {
            return $mfos;
        }
    }

    $mfos[] = $mfo;

    if ($mfo->parent_id) {
        $mfos = get_parent($mfos, $mfo->parent_id);
    }

    return $mfos;
}




function GET_SORTED_RSM_ROWS($mfos)
{
    if (empty($mfos)) return [];

    # sort parents first start -- according to the alphanumeric code
    $sorted_codes = [];


    foreach ($mfos as $key => $mfo) {
        if (!$mfo["parent_id"]) {
            $pms_rating_scale_matrices[] = $mfo;
        }
    }

    usort($pms_rating_scale_matrices, function ($item1, $item2) {
        return $item1['code'] <=> $item2['code'];
    });

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
    //    return $sorted_pms_rating_scale_matrices;

    $matrices = [];
    foreach ($pms_rating_scale_matrices as $key => $mfo) {
        $matrices[] = $mfo;
        # check if mfo has children
        $matrices = get_mfo_children($matrices, $mfo["id"]);
    }

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

    return $rows;
}


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
