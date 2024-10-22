<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\State;
use Illuminate\Http\Request;

class StateController extends Controller
{
    public function getStates($country_id)
    {
        $states = State::where('country_id', $country_id)->pluck('name', 'id');
    
        return response()->json($states);
    }
}
