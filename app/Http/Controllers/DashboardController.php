<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [];
        $data["title"] = "Dashboard";
        return view('dashboard.index', $data);
    }
}
