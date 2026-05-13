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
Route::get('turmas/{turma}/certificados', [\App\Http\Controllers\Admin\CertificadoController::class, 'index'])->name('certificados.index');
Route::post('turmas/{turma}/certificados/gerar-todos', [\App\Http\Controllers\Admin\CertificadoController::class, 'gerarTodos'])->name('certificados.gerar-todos');
Route::post('turmas/{turma}/alunos/{aluno}/certificado', [\App\Http\Controllers\Admin\CertificadoController::class, 'gerar'])->name('certificados.gerar');
Route::get('certificados/{certificado}/download', [\App\Http\Controllers\Admin\CertificadoController::class, 'download'])->name('certificados.download');
Route::get('acesso', [\App\Http\Controllers\Admin\AcessoController::class, 'index'])->name('acesso.index');
Route::get('acesso/leitura', [\App\Http\Controllers\Admin\AcessoController::class, 'leitura'])->name('acesso.leitura');
Route::post('acesso/registrar', [\App\Http\Controllers\Admin\AcessoController::class, 'registrar'])->name('acesso.registrar');
Route::get('acesso/resultado/{registro}', [\App\Http\Controllers\Admin\AcessoController::class, 'resultado'])->name('acesso.resultado');
Route::get('acesso/historico/{aluno}', [\App\Http\Controllers\Admin\AcessoController::class, 'historico'])->name('acesso.historico');
Route::get('diario', [\App\Http\Controllers\Admin\DiarioAulaController::class, 'index'])->name('diario.index');
Route::get('diario/{turma}', [\App\Http\Controllers\Admin\DiarioAulaController::class, 'turma'])->name('diario.turma');
});

// Rotas da Secretaria — novo grupo
Route::middleware(['auth', 'role:secretaria,admin'])->prefix('secretaria')->name('secretaria.')->group(function () {
    Route::get('saidas', [\App\Http\Controllers\Secretaria\SaidaAntecipadaController::class, 'index'])->name('saidas.index');
    Route::patch('saidas/{saida}/autorizar', [\App\Http\Controllers\Secretaria\SaidaAntecipadaController::class, 'autorizar'])->name('saidas.autorizar');
    Route::patch('saidas/{saida}/nao-autorizar', [\App\Http\Controllers\Secretaria\SaidaAntecipadaController::class, 'naoAutorizar'])->name('saidas.nao-autorizar');
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
    Route::get('saidas', [\App\Http\Controllers\Professor\SaidaAntecipadaController::class, 'index'])->name('saidas.index');
Route::get('saidas/registrar', [\App\Http\Controllers\Professor\SaidaAntecipadaController::class, 'create'])->name('saidas.create');
Route::post('saidas', [\App\Http\Controllers\Professor\SaidaAntecipadaController::class, 'store'])->name('saidas.store');
Route::get('/diario', [\App\Http\Controllers\Professor\DiarioAulaController::class, 'index'])->name('diario.index');
Route::get('/diario/{turma}', [\App\Http\Controllers\Professor\DiarioAulaController::class, 'turma'])->name('diario.turma');
Route::get('/diario/{turma}/nova', [\App\Http\Controllers\Professor\DiarioAulaController::class, 'create'])->name('diario.create');
Route::post('/diario/{turma}', [\App\Http\Controllers\Professor\DiarioAulaController::class, 'store'])->name('diario.store');
Route::get('/diario/{turma}/{aula}/editar', [\App\Http\Controllers\Professor\DiarioAulaController::class, 'edit'])->name('diario.edit');
Route::put('/diario/{turma}/{aula}', [\App\Http\Controllers\Professor\DiarioAulaController::class, 'update'])->name('diario.update');
Route::delete('/diario/{turma}/{aula}', [\App\Http\Controllers\Professor\DiarioAulaController::class, 'destroy'])->name('diario.destroy');
});

// Rotas da Empresa
Route::middleware(['auth', 'role:empresa'])->prefix('empresa')->name('empresa.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Empresa\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/alunos', [\App\Http\Controllers\Empresa\AlunosController::class, 'index'])->name('alunos.index');
    Route::get('/frequencia', [\App\Http\Controllers\Empresa\FrequenciaController::class, 'index'])->name('frequencia.index');
    Route::get('/frequencia/{aluno}', [\App\Http\Controllers\Empresa\FrequenciaController::class, 'show'])->name('frequencia.show');
});

// Rotas do Aluno
Route::middleware(['auth', 'role:aluno'])->prefix('aluno')->name('aluno.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Aluno\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/cracha', [\App\Http\Controllers\Aluno\QrCodeController::class, 'cracha'])->name('cracha');
    Route::get('/qrcode', [\App\Http\Controllers\Aluno\QrCodeController::class, 'imagem'])->name('imagem');
});

require __DIR__.'/auth.php';