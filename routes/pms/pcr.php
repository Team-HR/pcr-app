<?php
# PERFORMANCE COMMITMENT
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PMS\PCR\CoreFunctionController;
use App\Http\Controllers\PMS\PCR\PcrController;
use App\Http\Controllers\PMS\PCR\StrategicFunctionController;
use App\Http\Controllers\PMS\PCR\SupportFunctionController;
use Illuminate\Http\Request;
use App\Models\PMS\PCR\PmsPcrStrategicFunctionData;

Route::middleware(['auth'])->group(function () {
    # pcr
    Route::get("/pms/pcr", [PcrController::class, "index"])->name('pcr');
    Route::get("/pms/pcr/{period_id}", [PcrController::class, "show"]);
    Route::get("/pms/pcr/{period_id}/print/{form_status_id}", [PcrController::class, "print"]);

    # /pcr/{period_id}/submit
    // submit is on api.php
    Route::post("/pms/pcr/{period_id}/submit", [PcrController::class, "submit"]);

    # pcr - form type
    Route::get("/pms/pcr/{period_id}/form_type/{id}", [PcrController::class, "show_form_type"]);
    Route::post("/pms/pcr/{period_id}/form_type/{id}", [PcrController::class, "set_form_type"]);
    # pcr - signatories
    Route::get("/pms/pcr/{period_id}/signatories/{id}", [PcrController::class, "show_signatories"]);
    Route::post("/pms/pcr/{period_id}/signatories/{id}", [PcrController::class, "set_signatories"]);
    # pcr - core_functions
    Route::get("/pms/pcr/{period_id}/core_functions/{id}", [CoreFunctionController::class, "show"]);
    ##############################################################################
    ##############################################################################
    ##############################################################################
    ##############################################################################
    ##############################################################################
    ##############################################################################
    Route::post("/pms/pcr/{period_id}/core_functions/{id}/accomplishment", [CoreFunctionController::class, "create_update"]);
    Route::delete("/pms/pcr/{period_id}/core_functions/{id}/accomplishment/{accomplishment_id}", [CoreFunctionController::class, "delete_accomplishment"]);
    # pcr - strategic_function
    Route::get("/pms/pcr/{period_id}/strategic_function/{status_id}", [StrategicFunctionController::class, "show"]);
    Route::post("/pms/pcr/{period_id}/strategic_function/{status_id}", [StrategicFunctionController::class, "create_update"]);
    Route::delete("/pms/pcr/{period_id}/strategic_function/{status_id}/delete/{strat_id}", [StrategicFunctionController::class, "delete"]);
    # pcr - support functions
    Route::get("/pms/pcr/{period_id}/support_functions/{form_status_id}", [SupportFunctionController::class, "show"]);
    Route::post("/pms/pcr/{period_id}/support_functions/{form_status_id}/accomplishment", [SupportFunctionController::class, "create_accomplishment"]);
    Route::delete(
        "/pms/pcr/{period_id}/support_functions/{form_status_id}/accomplishment/{support_function_data_id}",
        [SupportFunctionController::class, "delete_accomplishment"]
    );

    Route::post('/pms/pcr_data', function (Request $request) {
        $pms_pcr_status_id = $request->pms_pcr_status['id'];
        $pms_period_id = $request->pms_pcr_status['pms_period_id'];
        $sys_employee_id = $request->pms_pcr_status['sys_employee_id'];

        $core_functions = (new CoreFunctionController)->get_row_data($pms_period_id, $pms_pcr_status_id, $sys_employee_id);

        $data = $core_functions;

        # get strategic function data
        $rows = PmsPcrStrategicFunctionData::where("pms_period_id", $pms_period_id)->where("sys_employee_id", $sys_employee_id)->get();
        $data["rows_strat"] = $rows;

        # get support function data
        $rows = (new SupportFunctionController)->get_support_function_rows($sys_employee_id, $pms_period_id);
        $data["rows_support"] = $rows;

        return $data;
    });


});
