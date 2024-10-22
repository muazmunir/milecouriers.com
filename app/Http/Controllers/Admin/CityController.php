<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function getCities($state_id)
    {
        $cities = City::where('state_id', $state_id)->pluck('name', 'id');
        return response()->json($cities);
    }
}
