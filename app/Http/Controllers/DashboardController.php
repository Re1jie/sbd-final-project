<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $pageTitle = 'Dashboard Toko Online';

        return view('dashboard.index', compact('pageTitle'));
    }
}
