<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('empresa.dashboard');
    }
}