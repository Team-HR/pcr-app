<?php
# PERFORMANCE MANAGEMENT SYSTEM
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\PMS\RSM\RatingScaleMatrixController;
use App\Http\Controllers\PMS\RSM\SuccessIndicatorController;
use App\Http\Controllers\PMS\IRSM\IndividualRatingScaleMatrixController;
use App\Http\Controllers\PMS\PCR\CoreFunctionController;
use App\Http\Controllers\PMS\PCR\PcrController;
use App\Http\Controllers\PMS\PCR\StrategicFunctionController;
use App\Http\Controllers\PMS\PCR\SupportFunctionController;
use App\Http\Controllers\PMS\RPC\ReviewPerformanceCommitmentController;
use App\Http\Controllers\PMS\SettingsController;

Route::middleware(['auth'])->group(function () {
    # pms dashboard
    Route::get('/pms', function () {
        return Inertia::render('Pms/Index');
    });

    # pms period selector


    # rating scale matrix
    Route::get('/pms/rsm', [RatingScaleMatrixController::class, "index"])->name('rsm');

    Route::get('/pms/rsm/{period_id}', [RatingScaleMatrixController::class, "show"])->name("rsm.show");
    Route::post('/pms/rsm/{period_id}', [RatingScaleMatrixController::class, "create"]);
    Route::patch('/pms/rsm/{period_id}', [RatingScaleMatrixController::class, "update"]);
    Route::delete('/pms/rsm/{period_id}/{id}', [RatingScaleMatrixController::class, "destroy"]);

    # success indicator
    Route::get('/pms/rsm/{period_id}/mfo/{id}/si', [SuccessIndicatorController::class, "index"]);
    Route::post('/pms/rsm/{period_id}/mfo/{id}/si', [SuccessIndicatorController::class, "create"]);
    Route::get('/pms/rsm/{period_id}/mfo/{rsm_id}/si/{id}', [SuccessIndicatorController::class, "edit"]);
    Route::patch('/pms/rsm/{period_id}/mfo/{rsm_id}/si/{id}', [SuccessIndicatorController::class, "update"]);
    Route::delete('/pms/rsm/{period_id}/mfo/{rsm_id}/si/{id}', [SuccessIndicatorController::class, "destroy"]);

    # individual rating scale matrix
    Route::get("/pms/irsm", [IndividualRatingScaleMatrixController::class, "index"])->name('irsm');
    Route::get("/pms/irsm/{period_id}", [IndividualRatingScaleMatrixController::class, "show"]);

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
    Route::delete("/pms/pcr/{period_id}/support_functions/{form_status_id}/accomplishment/{support_function_data_id}", [SupportFunctionController::class, "delete_accomplishment"]);

    # rpc - review performance commitment reports
    Route::get("/pms/rpc", [ReviewPerformanceCommitmentController::class, "index"]);
    Route::get("/pms/rpc/{period_id}", [ReviewPerformanceCommitmentController::class, "show"]);
    Route::get("/pms/rpc/{pms_pcr_status_id}/form", [ReviewPerformanceCommitmentController::class, "showPcr"]);
    Route::post("/pms/rpc/{period_id}/form/accomplishment", [CoreFunctionController::class, "create_update"]);

    # pms - settings
    Route::get("/pms/settings", [SettingsController::class, "index"]);
    Route::get("/pms/settings/periods", [SettingsController::class, "periods"]);
    Route::post("/pms/settings/periods/create", [SettingsController::class, "create_period"]);
    Route::get("/pms/settings/support_functions", [SettingsController::class, "support_functions"]);
    Route::get("/pms/settings/support_functions/{id}", [SettingsController::class, "support_functions_setup"]);
    Route::post("/pms/settings/support_functions/{id}", [SettingsController::class, "get_support_functions"]);
    Route::delete("/pms/settings/support_function/{id}", [SettingsController::class, "delete_support_function"]);
    Route::post("/pms/settings/support_functions/{id}/getSimilarRatingScaleMeasures", [SettingsController::class, "get_similar_rating_scale_measures"]);
    Route::post("/pms/settings/support_functions/{id}/move", [SettingsController::class, "move"]);
    Route::post("/pms/settings/support_functions/{id}/create", [SettingsController::class, "support_functions_setup_create_update"]);
});
