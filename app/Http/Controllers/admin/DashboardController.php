<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard()
    {
        if (!Auth::check())
        {
            return redirect()->route('login');
        }
        $name = Auth::user()->name;
        return view('admin.dashboard', compact('name'));
    }
}
