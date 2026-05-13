<?php

namespace App\Http\Controllers\Aluno;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $aluno = Auth::user()->aluno;
        return view('aluno.dashboard', compact('aluno'));
    }
}
