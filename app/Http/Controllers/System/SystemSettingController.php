<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use App\Models\SysEmployee;
use App\Models\User;

class SystemSettingController extends Controller
{
    public function index()
    {
        return Inertia::render('System/Settings/Index');
    }

}
