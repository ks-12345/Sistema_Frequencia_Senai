<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Professor\DashboardController as ProfessorDashboard;
use App\Http\Controllers\Empresa\DashboardController as EmpresaDashboard;

Route::get('/', function () {
    return redirect()->route('login');
});

// Rotas do Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
    Route::resource('empresas',   \App\Http\Controllers\Admin\EmpresaController::class);
    Route::resource('alunos',     \App\Http\Controllers\Admin\AlunoController::class);
    Route::resource('turmas',     \App\Http\Controllers\Admin\TurmaController::class);
    Route::resource('professores',\App\Http\Controllers\Admin\ProfessorController::class);
});

// Rotas do Professor
Route::middleware(['auth', 'role:professor'])->prefix('professor')->name('professor.')->group(function () {
    Route::get('/dashboard', [ProfessorDashboard::class, 'index'])->name('dashboard');
});

// Rotas da Empresa
Route::middleware(['auth', 'role:empresa'])->prefix('empresa')->name('empresa.')->group(function () {
    Route::get('/dashboard', [EmpresaDashboard::class, 'index'])->name('dashboard');
});

require __DIR__.'/auth.php';