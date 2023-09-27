<?php

namespace App\Http\Controllers\PMS\PCR;

use App\Http\Controllers\Controller;
use App\Models\PMS\PCR\PmsPcrSupportFunction;
use App\Models\PMS\PCR\PmsPcrSupportFunctionData;
use App\Models\PMS\PCR\PmsPcrStatus;
use App\Models\PMS\PmsPeriod;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;


class SupportFunctionController extends Controller
{
    public function show($pms_period_id)
    {
        $period = PmsPeriod::find($pms_period_id);
        $rows = [];
        $sys_employee_id = auth()->user()->sys_employee_id;
        $support_function_data = $this->get_support_function_rows($sys_employee_id, $pms_period_id);
        return Inertia::render("PMS/PCR/SupportFunctions", [
            "period" => $period, "rows" => $support_function_data["data"],
            "total_numerical_rating" => $support_function_data["total_numerical_rating"],
            "total_percentage_weight" => $support_function_data["total_percentage_weight"]
        ]);
    }

    public function create_accomplishment($pms_period_id, Request $request)
    {
        if (!$request->id) {
            $accomplishment_data = new PmsPcrSupportFunctionData();
            $accomplishment_data->pms_performance_commitment_review_support_function_id = $request->support_func_id;
            $accomplishment_data->pms_period_id = $pms_period_id;
            $accomplishment_data->sys_employee_id = auth()->user()->sys_employee_id;
            $accomplishment_data->accomplishment = $request->accomplishment;
            $accomplishment_data->quality = $request->quality;
            $accomplishment_data->efficiency = $request->efficiency;
            $accomplishment_data->timeliness = $request->timeliness;
            $accomplishment_data->percent = $request->percent;
            // $accomplishment_data->remarks = $request->remarks;
            // $accomplishment_data->not_applicable = $request->not_applicable ? true : false;
        } else {
            $accomplishment_data = PmsPcrSupportFunctionData::find($request->id);
            $accomplishment_data->pms_performance_commitment_review_support_function_id = $request->support_func_id;
            $accomplishment_data->pms_period_id = $pms_period_id;
            $accomplishment_data->sys_employee_id = auth()->user()->sys_employee_id;
            $accomplishment_data->accomplishment = $request->accomplishment;
            $accomplishment_data->quality = $request->quality;
            $accomplishment_data->efficiency = $request->efficiency;
            $accomplishment_data->timeliness = $request->timeliness;
            $accomplishment_data->percent = $request->percent;
            // $accomplishment_data->remarks = $request->remarks;
            // $accomplishment_data->not_applicable = $request->not_applicable ? true : false;
        }
        $accomplishment_data->save();
        return Redirect::back();
    }

    public function delete_accomplishment($period_id, $form_status_id, $accomplishment_id)
    {
        $accomplishment = PmsPcrSupportFunctionData::find($accomplishment_id);
        $accomplishment->delete();
        return Redirect::back();
    }


    /**
     * 
     * Get all support functions with accomplishment from 
     * PmsPcrSupportFunctionData
     * with form type, pms_period_id and sys_employee_id
     * 
     * */

    public function get_support_function_rows($sys_employee_id, $pms_period_id)
    {
        $data = [];
        $total_numerical_rating = 0;
        $total_percentage_weight = 0;

        $support_functions = get_support_functions($sys_employee_id, $pms_period_id);

        foreach ($support_functions as $key => $support_func) {

            $id = $support_func["id"];
            $support_func_data = PmsPcrSupportFunctionData::where('pms_performance_commitment_review_support_function_id', $id)->where('sys_employee_id', $sys_employee_id)->where('pms_period_id', $pms_period_id)->first();

            $percent = $support_func["percent"];

            $support_func_data_id = null;
            $accomplishment = null;
            $quality = null;
            $efficiency = null;
            $timeliness = null;
            $average = null;
            // $percent = 0;

            if ($support_func_data) {
                $support_func_data_id = $support_func_data["id"];
                $accomplishment = $support_func_data["accomplishment"];
                $quality = $support_func_data["quality"];
                $efficiency = $support_func_data["efficiency"];
                $timeliness = $support_func_data["timeliness"];
                $percent_data = $support_func_data["percent"];

                if ($percent_data != 0) {
                    $count = 0;
                    $total_scores = 0;
                    if ($quality) {
                        $count++;
                        $total_scores += $quality;
                    }
                    if ($efficiency) {
                        $count++;
                        $total_scores += $efficiency;
                    }
                    if ($timeliness) {
                        $count++;
                        $total_scores += $timeliness;
                    }
                    if ($count > 0) {
                        $average = ($total_scores / $count) * $percent_data / 100;
                        $average = floatval(number_format($average, 3));
                        $total_numerical_rating += $average;
                    }
                }
            }

            $datum = [
                "id" => $support_func_data_id,
                "support_func_id" => $id,
                "support_function" => $support_func["support_function"],
                "success_indicator" => $support_func["success_indicator"],
                "accomplishment" => $accomplishment,
                "quality_options" => $support_func["quality"],
                "quality" => $quality,
                "efficiency_options" => $support_func["efficiency"],
                "efficiency" => $efficiency,
                "timeliness_options" => $support_func["timeliness"],
                "timeliness" => $timeliness,
                "average" => $average,
                "percent" => $percent
            ];
            $total_percentage_weight += $percent;
            $data[] = $datum;
        }


        $data = [
            "data" => $data,
            "total_numerical_rating" => bcdiv($total_numerical_rating, 1, 2),
            "total_percentage_weight" => $total_percentage_weight
        ];


        return $data;
    }
}


/**
 * 
 * Get all support functions from 
 * PmsPcrSupportFunction
 * with form type, pms_period_id and sys_employee_id
 * 
 * */

function get_support_functions($sys_employee_id, $pms_period_id)
{
    // check form type from status
    $data = [];
    $pcr_status = PmsPcrStatus::where('sys_employee_id', $sys_employee_id)->where('pms_period_id', $pms_period_id)->first();
    // if no status not execute and return []
    if ($pcr_status) {
        $form_type = $pcr_status["form_type"];
        $support_functions = PmsPcrSupportFunction::where(
            'form_type',
            $form_type
        )->where('pms_period_id', $pms_period_id)->orderBy('order_num')->get();
        $data = $support_functions;
    }
    return $data;
}


function get_numerical_rating($sys_employee_id, $pms_period_id)
{
    $total_numerical_rating = 0;
    $support_functions = get_support_functions($sys_employee_id, $pms_period_id);
    foreach ($support_functions as $key => $support_func) {

        $id = $support_func["id"];
        $support_func_data = PmsPcrSupportFunctionData::where('pms_performance_commitment_review_support_function_id', $id)->where('sys_employee_id', $sys_employee_id)->where('pms_period_id', $pms_period_id)->first();

        $quality = null;
        $efficiency = null;
        $timeliness = null;
        $average = null;

        if ($support_func_data) {
            $quality = $support_func_data["quality"];
            $efficiency = $support_func_data["efficiency"];
            $timeliness = $support_func_data["timeliness"];
            $percent_data = $support_func_data["percent"];

            if ($percent_data != 0) {
                $count = 0;
                $total_scores = 0;
                if ($quality) {
                    $count++;
                    $total_scores += $quality;
                }
                if ($efficiency) {
                    $count++;
                    $total_scores += $efficiency;
                }
                if ($timeliness) {
                    $count++;
                    $total_scores += $timeliness;
                }
                if ($count > 0) {
                    $average = ($total_scores / $count) * $percent_data / 100;
                    $average = floatval(number_format($average, 3));
                    $total_numerical_rating += $average;
                }
            }
        }
    }

    return $total_numerical_rating;
}
