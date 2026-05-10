<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Turma;
use App\Models\Aluno;
use App\Models\Certificado;
use App\Models\Frequencia;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

class CertificadoController extends Controller
{
    public function index(Turma $turma)
    {
        if (!$turma->isFinalizada()) {
            return redirect()->route('admin.turmas.index')
                             ->with('error', 'Só é possível gerar certificados para turmas finalizadas.');
        }

        $certificados = Certificado::with('aluno')
            ->where('turma_id', $turma->id)
            ->get()
            ->keyBy('aluno_id');

        $alunos = $turma->alunos;

        return view('admin.certificados.index', compact('turma', 'alunos', 'certificados'));
    }

    public function gerar(Turma $turma, Aluno $aluno)
    {
        if (!$turma->isFinalizada()) {
            return back()->with('error', 'Turma ainda não finalizada.');
        }

        // Calcula percentual de presença
        $totalAulas = Frequencia::where('aluno_id', $aluno->id)
            ->whereHas('aluno', fn($q) => $q->where('turma_id', $turma->id))
            ->where('status_aprovacao', 'aprovado')
            ->count();

        $presencas = Frequencia::where('aluno_id', $aluno->id)
            ->where('status_presenca', 'presente')
            ->where('status_aprovacao', 'aprovado')
            ->count();

        $percentual = $totalAulas > 0 ? round(($presencas / $totalAulas) * 100, 2) : 0;

        // Cria ou atualiza certificado
        $certificado = Certificado::updateOrCreate(
            ['aluno_id' => $aluno->id, 'turma_id' => $turma->id],
            [
                'codigo'              => strtoupper(Str::random(12)),
                'percentual_presenca' => $percentual,
                'carga_horaria'       => $turma->carga_horaria,
                'data_conclusao'      => $turma->finalizada_em ?? now(),
            ]
        );

        return redirect()->route('admin.certificados.index', $turma)
                         ->with('success', "Certificado gerado para {$aluno->nome}!");
    }

    public function gerarTodos(Turma $turma)
    {
        if (!$turma->isFinalizada()) {
            return back()->with('error', 'Turma ainda não finalizada.');
        }

        foreach ($turma->alunos as $aluno) {
            $totalAulas = Frequencia::where('aluno_id', $aluno->id)
                ->where('status_aprovacao', 'aprovado')
                ->count();

            $presencas = Frequencia::where('aluno_id', $aluno->id)
                ->where('status_presenca', 'presente')
                ->where('status_aprovacao', 'aprovado')
                ->count();

            $percentual = $totalAulas > 0 ? round(($presencas / $totalAulas) * 100, 2) : 0;

            Certificado::updateOrCreate(
                ['aluno_id' => $aluno->id, 'turma_id' => $turma->id],
                [
                    'codigo'              => strtoupper(Str::random(12)),
                    'percentual_presenca' => $percentual,
                    'carga_horaria'       => $turma->carga_horaria,
                    'data_conclusao'      => $turma->finalizada_em ?? now(),
                ]
            );
        }

        return redirect()->route('admin.certificados.index', $turma)
                         ->with('success', 'Certificados gerados para todos os alunos!');
    }

    public function download(Certificado $certificado)
    {
        $certificado->load(['aluno.turma', 'turma']);

        $pdf = Pdf::loadView('admin.certificados.pdf', compact('certificado'))
                  ->setPaper('a4', 'landscape');

        return $pdf->download("certificado_{$certificado->aluno->nome}.pdf");
    }
}