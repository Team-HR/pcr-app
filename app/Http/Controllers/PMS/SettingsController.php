<?php

namespace App\Http\Controllers\PMS;

use App\Http\Controllers\Controller;
use App\Models\PMS\PCR\PmsPcrStatus;
use App\Models\PMS\PCR\PmsPcrSupportFunction;
use App\Models\PMS\PmsPeriod;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

class SettingsController extends Controller
{
    public function index()
    {
        return Inertia::render('PMS/Settings/Index');
    }

    public function periods()
    {
        $periods = PmsPeriod::all();
        $years = [];
        foreach ($periods as $period) {
            if (!in_array($period["year"], $years)) {
                $years[] = $period["year"];
            }
        }

        $_years = [];

        foreach ($years as $year) {
            $_years[] = [
                "year" => $year,
                "firstPeriod" => "January - June",
                "secondPeriod" => "July - December"
            ];
        }

        rsort($_years);

        return Inertia::render('Pms/Settings/Periods', ['years' => $_years]);
    }


    public function support_functions()
    {
        return Inertia::render('PMS/Settings/SupportFunctions');
    }

    public function create_period(Request $request)
    {
        $year = $request->year;

        // check first if year  already exist
        $res = PmsPeriod::where("year", $year)->get();
        $exists = count($res);
        if ($exists < 1) {
            // return "create";
            // PmsPeriod::create([
            //     "period" => "January - June",
            //     "year" => $year,
            // ]);

            $pmsPeriod = new PmsPeriod;
            $pmsPeriod->period = "January - June";
            $pmsPeriod->year = $year;
            $pmsPeriod->save();

            $pmsPeriod = new PmsPeriod;
            $pmsPeriod->period = "July - December";
            $pmsPeriod->year = $year;
            $pmsPeriod->save();

            // PmsPeriod::create([
            //     "period" => "July - December",
            //     "year" => $year,
            // ]);
            return Redirect::back();
        }
        // return "exists";
        return Redirect::back();
    }

    public function get_similar_rating_scale_measures($id, Request $request)
    {
        $type = $request->type;
        $val = $request->val;

        // pms_pcr_support_functions
        $res = PmsPcrSupportFunction::where("{$type}", 'LIKE', "%{$val}%")->get();

        $suggestions = [];
        foreach ($res as $val) {
            $suggestions[] = $val[$type];
        }

        return [
            "suggestions" => $suggestions
        ];
    }

    public function support_functions_setup($period_id)
    {

        $period = PmsPeriod::find($period_id);
        return Inertia::render("PMS/Settings/SupportFunctionsEditor", ["period" => $period]);
    }

    public function delete_support_function($id)
    {
        $support_function = PmsPcrSupportFunction::find($id);
        $support_function->delete();
        return Redirect::back();
    }

    public function support_functions_setup_create_update($period_id, Request $request)
    {
        // return Inertia::render("Pms/Settings/SupportFunctionsPeriodEditor");

        $id = $request->id;
        $support_function = $request->support_function;
        $success_indicator = $request->success_indicator;
        $quality = $request->quality;
        $efficiency = $request->efficiency;
        $timeliness = $request->timeliness;
        $percent = $request->percent;
        $form_type = $request->form_type;

        // check measures if empty
        // $countEmpty = 0;
        // foreach ($request->timeliness as $measure) {
        //     if (!$measure) {
        //         $countEmpty++;
        //     }
        // }
        // return $countEmpty;

        $quality = measureIsNotEmpty($quality) ? $quality : [];
        $efficiency = measureIsNotEmpty($efficiency) ? $efficiency : [];
        $timeliness = measureIsNotEmpty($timeliness) ? $timeliness : [];

        if (!$id) {
            // create new PmsPcrSupportFunction
            $last_order_num = get_last_order_num($period_id, $form_type["code"]);
            $supportFunction = new PmsPcrSupportFunction();
            $supportFunction->pms_period_id = $period_id;
            $supportFunction->order_num = $last_order_num;
            $supportFunction->support_function = $support_function;
            $supportFunction->success_indicator = $success_indicator;
            $supportFunction->quality = $quality;
            $supportFunction->efficiency = $efficiency;
            $supportFunction->timeliness = $timeliness;
            $supportFunction->percent = $percent;
            $supportFunction->form_type = $form_type["code"];
            $supportFunction->save();
        } else {
            // update PmsPcrSupportFunction
            $supportFunction = PmsPcrSupportFunction::find($id);
            $supportFunction->support_function = $support_function;
            $supportFunction->success_indicator = $success_indicator;
            $supportFunction->quality = $quality;
            $supportFunction->efficiency = $efficiency;
            $supportFunction->timeliness = $timeliness;
            $supportFunction->percent = $percent;
            $supportFunction->save();
        }

        return Redirect::back();
    }

    public function get_support_functions($period_id, Request $request)
    {
        $supportFunctions = PmsPcrSupportFunction::where("pms_period_id", $period_id)->where("form_type", $request->form_type["code"])->orderBy('order_num')->get();
        return $supportFunctions;
    }


    public function move($period_id, Request $request)
    {
        // return $request->to;
        $supportFunctions = PmsPcrSupportFunction::where('pms_period_id', $period_id)->where('form_type', $request->form_type['code'])->orderBy('order_num')->get();

        $newOrderedsupportFunctions = [];
        foreach ($supportFunctions as $supportFunction) {
            $newOrderedsupportFunctions[] = $supportFunction;
        }

        moveElement($newOrderedsupportFunctions, $request->from, $request->to);

        foreach ($newOrderedsupportFunctions as $key => $function) {
            $PmsPcrSupportFunction = PmsPcrSupportFunction::find($function['id']);
            $PmsPcrSupportFunction->order_num = $key;
            $PmsPcrSupportFunction->save();
        }

        return [$supportFunctions, $newOrderedsupportFunctions];
    }

    // public function test()
    // {
    //     $period_id = 11;
    //     $form_type = 'ipcr';

    //     return get_last_order_num($period_id, $form_type);
    // }

}

function moveElement(&$array, $a, $b)
{
    $out = array_splice($array, $a, 1);
    array_splice($array, $b, 0, $out);
}

function measureIsNotEmpty($arr)
{
    foreach ($arr as $measure) {
        if ($measure) {
            return true;
        }
    }
    return false;
}


function get_last_order_num($period_id, $form_type)
{
    $supportFunction = PmsPcrSupportFunction::where('pms_period_id', $period_id)->where('form_type', $form_type)->orderByDesc('order_num')->first();
    return $supportFunction ? $supportFunction['order_num'] + 1 : 0;
}
