<?php
# PERFORMANCE MANAGEMENT SYSTEM


use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\SysEmployee;
use App\Models\User;

Route::middleware(['auth'])->group(function () {
    # system settings
    Route::get('/system/settings', function () {
        return Inertia::render('System/Settings/Index');
    });

    # get list of employees
    Route::get('/system/settings/employees', function () {
        $employees = SysEmployee::all();
        return Inertia::render('System/Settings/Employees', ["employees" => $employees]);
    });

    # store or update employee 
    Route::post('/system/settings/employees', function (Request $request) {
        // $employees = SysEmployee::all();
        // return $request->all();
        # if $request->id null create new
        $emp = new SysEmployee();
        $emp->id = $request->id;
        $emp->last_name = $request->last_name;
        $emp->first_name = $request->first_name;
        $emp->middle_name = $request->middle_name;
        $emp->ext = $request->ext_name;
        $emp->gender = $request->gender['code'];
        $emp->is_employee = 1;
        $emp->is_active = 1;
        $emp->save();
        $sys_employee_id =  $emp->id;
        if ($request->username) {
            $emp = SysEmployee::find($sys_employee_id);
            $name = $emp->full_name;
            $user = new User();
            $user->name = $name;
            $user->username = $request->username;
            $user->sys_employee_id = $sys_employee_id;
            $user->roles = [];
            $user->password = Hash::make('1234');
            $user->save();
        }
        // return $request->all();
    });
});
