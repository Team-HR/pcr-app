<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use App\Models\SysEmployee;
use App\Models\User;

class SysEmployeeController extends Controller
{
    public function index()
    {
        $employees = SysEmployee::all();
        return Inertia::render('System/Settings/Employees', ["employees" => $employees]);
    }

    public function store(Request $request)
    {
        // $employees = SysEmployee::all();
        // return $request->all();
        # if $request->id null create new
        $emp = new SysEmployee();
        $emp->id = $request->id;
        $emp->last_name = mb_convert_case($request->last_name, MB_CASE_UPPER, "UTF-8");
        $emp->first_name = mb_convert_case($request->first_name, MB_CASE_UPPER, "UTF-8");
        $emp->middle_name = mb_convert_case($request->middle_name, MB_CASE_UPPER, "UTF-8");
        $emp->ext = mb_convert_case($request->ext_name, MB_CASE_UPPER, "UTF-8");
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
    }
}
