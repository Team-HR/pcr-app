<?php

namespace App\Http\Controllers\PMS\IRSM;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PMS\PCR\CoreFunctionController;
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

        $core_function = new CoreFunctionController();
        $rows = $core_function->get_rows($period_id, $sys_employee_id);

        return Inertia::render("PMS/IRSM/IndividualRatingScaleMatrix", [
            "period" => $period, "rows" => $rows
        ]);
    }
}
