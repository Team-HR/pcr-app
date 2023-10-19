<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\System\SystemSettingController;
use App\Http\Controllers\System\SysEmployeeController;
use App\Models\SysEmployee;

Route::middleware(['auth'])->group(function () {
    # system settings
    Route::get('/system/settings', [SystemSettingController::class, "index"])->name('sys_settings');

    # get list of employees
    Route::get('/system/settings/employees', [SysEmployeeController::class, "index"]);

    # store or update employee 
    Route::post('/system/settings/employees', [SysEmployeeController::class, "store"]);
});
