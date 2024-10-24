<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function adminIndex(): View
    {
        return view('admin.dashboard');
    }
}
