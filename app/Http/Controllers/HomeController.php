<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $pageTitle = 'Home';

        return view('frontend.index', compact('pageTitle'));
    }
}
