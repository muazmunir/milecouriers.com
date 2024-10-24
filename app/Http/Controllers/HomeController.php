<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        $pageTitle = 'Home';

        return view('frontend.index', compact('pageTitle'));
    }
}
