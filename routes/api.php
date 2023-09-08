<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



use App\Models\PMS\PmsPeriod;

Route::get('/pms/periods', function () {
    $periods = PmsPeriod::orderByDesc('year')->get()->toArray();
    $data = [];

    foreach ($periods as $index => $period) {
        if (count($data) > 0) {
            $data_key = -1;
            foreach ($data as $key => $datum) {
                if ($datum["year"] == $period["year"]) {
                    $data_key = $key;
                    break;
                }
            }
            if ($data_key < 0) {
                $data[] = [
                    "year" => $period["year"],
                    "period1" => $period["period"] == "January - June" ? $period["id"] : null,
                    "period2" => $period["period"] == "July - December" ? $period["id"] : null,
                ];
            } else {
                if ($period["period"] == "January - June") {
                    $data[$data_key]["period1"] =  $period["id"];
                } else if ($period["period"] == "July - December") {
                    $data[$data_key]["period2"] =  $period["id"];
                }
            }
        } else {
            $data[] = [
                "year" => $period["year"],
                "period1" => $period["period"] == "January - June" ? $period["id"] : null,
                "period2" => $period["period"] == "July - December" ? $period["id"] : null,
            ];
        }
    }

    return $data;
});