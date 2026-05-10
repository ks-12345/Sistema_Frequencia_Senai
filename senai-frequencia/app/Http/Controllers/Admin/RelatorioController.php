<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aluno;
use App\Models\Turma;
use App\Models\Empresa;
use App\Models\Frequencia;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class RelatorioController extends Controller
{
    public function index()
    {
        $turmas   = Turma::orderBy('nome')->get();
        $empresas = Empresa::orderBy('nome')->get();
        $alunos   = Aluno::orderBy('nome')->get();

        return view('admin.relatorios.index', compact('turmas', 'empresas', 'alunos'));
    }

    public function exportarPdf(Request $request)
    {
        $request->validate([
            'tipo'       => 'required|in:aluno,turma,empresa,geral',
            'data_inicio'=> 'nullable|date',
            'data_fim'   => 'nullable|date|after_or_equal:data_inicio',
        ]);

        $frequencias = $this->buscarFrequencias($request);
        $titulo      = $this->getTitulo($request);

        $pdf = Pdf::loadView('admin.relatorios.pdf', compact('frequencias', 'titulo', 'request'))
                  ->setPaper('a4', 'landscape');

        return $pdf->download("relatorio_{$request->tipo}.pdf");
    }

    public function exportarExcel(Request $request)
    {
        $request->validate([
            'tipo'       => 'required|in:aluno,turma,empresa,geral',
            'data_inicio'=> 'nullable|date',
            'data_fim'   => 'nullable|date|after_or_equal:data_inicio',
        ]);

        $frequencias = $this->buscarFrequencias($request);
        $titulo      = $this->getTitulo($request);

        // Gera CSV manualmente (sem dependência extra)
        $filename = "relatorio_{$request->tipo}.csv";
        $headers  = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($frequencias) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF)); // BOM UTF-8

            fputcsv($file, ['Data', 'Aluno', 'Matrícula', 'Turma', 'Empresa', 'Status', 'Lançado por', 'Observação'], ';');

            foreach ($frequencias as $f) {
                fputcsv($file, [
                    $f->data->format('d/m/Y'),
                    $f->aluno->nome,
                    $f->aluno->matricula,
                    $f->aluno->turma->nome ?? '—',
                    $f->aluno->empresa->nome ?? '—',
                    ucfirst($f->status_presenca),
                    $f->lancadoPor->name ?? '—',
                    $f->observacao ?? '',
                ], ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function buscarFrequencias(Request $request)
    {
        $query = Frequencia::with(['aluno.turma', 'aluno.empresa', 'lancadoPor'])
            ->where('status_aprovacao', 'aprovado')
            ->orderBy('data', 'desc');

        if ($request->tipo === 'aluno' && $request->aluno_id) {
            $query->where('aluno_id', $request->aluno_id);
        }

        if ($request->tipo === 'turma' && $request->turma_id) {
            $query->whereHas('aluno', fn($q) => $q->where('turma_id', $request->turma_id));
        }

        if ($request->tipo === 'empresa' && $request->empresa_id) {
            $query->whereHas('aluno', fn($q) => $q->where('empresa_id', $request->empresa_id));
        }

        if ($request->data_inicio) {
            $query->whereDate('data', '>=', $request->data_inicio);
        }

        if ($request->data_fim) {
            $query->whereDate('data', '<=', $request->data_fim);
        }

        return $query->get();
    }

    public function visualizar(Request $request)
{
    $request->validate([
        'tipo'        => 'required|in:aluno,turma,empresa,geral',
        'data_inicio' => 'nullable|date',
        'data_fim'    => 'nullable|date|after_or_equal:data_inicio',
    ]);

    $frequencias = $this->buscarFrequencias($request);
    $titulo      = $this->getTitulo($request);
    $turmas      = Turma::orderBy('nome')->get();
    $empresas    = Empresa::orderBy('nome')->get();
    $alunos      = Aluno::orderBy('nome')->get();

    // Estatísticas
    $totalRegistros = $frequencias->count();
    $totalPresencas = $frequencias->where('status_presenca', 'presente')->count();
    $totalFaltas    = $frequencias->where('status_presenca', 'falta')->count();
    $totalAtrasos   = $frequencias->where('status_presenca', 'atraso')->count();
    $percentual     = $totalRegistros > 0
        ? round(($totalPresencas / $totalRegistros) * 100, 1)
        : 0;

    return view('admin.relatorios.visualizar', compact(
        'frequencias', 'titulo', 'request',
        'turmas', 'empresas', 'alunos',
        'totalRegistros', 'totalPresencas',
        'totalFaltas', 'totalAtrasos', 'percentual'
    ));
}

    private function getTitulo(Request $request): string
    {
        return match($request->tipo) {
            'aluno'   => 'Relatório por Aluno',
            'turma'   => 'Relatório por Turma',
            'empresa' => 'Relatório por Empresa',
            default   => 'Relatório Geral',
        };
    }
}