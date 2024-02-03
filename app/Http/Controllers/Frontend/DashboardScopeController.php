<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardScopeController extends Controller
{
    public function scopeone(Request $request)
    {
        return view('dashboardscopeone');
    }

    public function scopetwo(Request $request)
    {
        return view('dashboardscopetwo');
    }

    public function scopethree(Request $request)
    {
        return view('dashboardscopethree');
    }
}
