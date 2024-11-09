<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{ 
    /**
     * create dashboard page view
     *
     * 
     *
     * 
     */
    public function dashboard()
    {
        return view('dashboard');
    }
}
