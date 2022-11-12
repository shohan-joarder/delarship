<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Vendor;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function getCity()
    {
        $allCity = City::where('status', 1)->orderBy('name', 'asc')->get();
        return response()->json(['status' => 'success', 'data' => $allCity], 200);
    }
    public function getVendors()
    {
        $allVendor = Vendor::where('status', 1)->orderBy('name', 'asc')->get();
        return response()->json(['status' => 'success', 'data' => $allVendor], 200);
    }
}
