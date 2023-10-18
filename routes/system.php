<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\System\SystemSettingsController;
use App\Http\Controllers\System\SysEmployeesController;
use App\Models\SysEmployee;

Route::middleware(['auth'])->group(function () {
    # system settings
    Route::get('/system/settings', [SystemSettingsController::class, "index"])->name('sys_settings');

    # get list of employees
    Route::get('/system/settings/employees', [SysEmployeesController::class, "index"]);

    # store or update employee 
    Route::post('/system/settings/employees', [SysEmployeesController::class, "store"]);
});
