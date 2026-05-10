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
    Route::get('substitutos', [\App\Http\Controllers\Admin\SubstitutoController::class, 'index'])->name('substitutos.index');
Route::get('substitutos/criar', [\App\Http\Controllers\Admin\SubstitutoController::class, 'create'])->name('substitutos.create');
Route::post('substitutos', [\App\Http\Controllers\Admin\SubstitutoController::class, 'store'])->name('substitutos.store');
Route::delete('substitutos/{substituto}', [\App\Http\Controllers\Admin\SubstitutoController::class, 'destroy'])->name('substitutos.destroy');
Route::get('relatorios', [\App\Http\Controllers\Admin\RelatorioController::class, 'index'])->name('relatorios.index');
Route::get('relatorios/pdf', [\App\Http\Controllers\Admin\RelatorioController::class, 'exportarPdf'])->name('relatorios.pdf');
Route::get('relatorios/csv', [\App\Http\Controllers\Admin\RelatorioController::class, 'exportarExcel'])->name('relatorios.csv');
Route::get('relatorios/visualizar', [\App\Http\Controllers\Admin\RelatorioController::class, 'visualizar'])->name('relatorios.visualizar');
Route::patch('turmas/{turma}/finalizar', [\App\Http\Controllers\Admin\TurmaController::class, 'finalizar'])->name('turmas.finalizar');
Route::patch('turmas/{turma}/reativar', [\App\Http\Controllers\Admin\TurmaController::class, 'reativar'])->name('turmas.reativar');
Route::get('alunos/{aluno}/cracha', [\App\Http\Controllers\Admin\QrCodeController::class, 'cracha'])->name('qrcode.cracha');
Route::get('alunos/{aluno}/qrcode', [\App\Http\Controllers\Admin\QrCodeController::class, 'imagem'])->name('qrcode.imagem');
Route::get('qrcode/ler/{token}', [\App\Http\Controllers\Admin\QrCodeController::class, 'lerQrCode'])->name('qrcode.ler');
});


// Rotas do Professor
Route::middleware(['auth', 'role:professor'])->prefix('professor')->name('professor.')->group(function () {
    Route::get('/dashboard', [ProfessorDashboard::class, 'index'])->name('dashboard');
    Route::get('/frequencia', [\App\Http\Controllers\Professor\FrequenciaController::class, 'index'])->name('frequencia.index');
    Route::get('/frequencia/{turma}/lancar', [\App\Http\Controllers\Professor\FrequenciaController::class, 'lancar'])->name('frequencia.lancar');
    Route::post('/frequencia', [\App\Http\Controllers\Professor\FrequenciaController::class, 'store'])->name('frequencia.store');
    Route::get('/frequencia/pendentes', [\App\Http\Controllers\Professor\FrequenciaController::class, 'pendentes'])->name('frequencia.pendentes');
    Route::patch('/frequencia/{frequencia}/aprovar', [\App\Http\Controllers\Professor\FrequenciaController::class, 'aprovar'])->name('frequencia.aprovar');
    Route::patch('/frequencia/{frequencia}/rejeitar', [\App\Http\Controllers\Professor\FrequenciaController::class, 'rejeitar'])->name('frequencia.rejeitar');
});

// Rotas da Empresa
Route::middleware(['auth', 'role:empresa'])->prefix('empresa')->name('empresa.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Empresa\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/frequencia', [\App\Http\Controllers\Empresa\FrequenciaController::class, 'index'])->name('frequencia.index');
    Route::get('/frequencia/{aluno}', [\App\Http\Controllers\Empresa\FrequenciaController::class, 'show'])->name('frequencia.show');
});


require __DIR__.'/auth.php';