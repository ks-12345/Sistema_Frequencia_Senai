<?php

namespace App\Http\Controllers\Secretaria;

use App\Http\Controllers\Controller;
use App\Models\Frequencia;
use App\Models\Turma;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrequenciaController extends Controller
{
    public function index()
    {
        $turmas = Turma::withCount('alunos')->orderBy('nome')->get();

        $resumo = Frequencia::selectRaw(
            'alunos.turma_id as turma_id,
            COUNT(*) as total,
            SUM(CASE WHEN status = "pendente_aprovacao" THEN 1 ELSE 0 END) as pendentes,
            SUM(CASE WHEN status = "aprovado" THEN 1 ELSE 0 END) as aprovadas,
            SUM(CASE WHEN status = "devolvido_correcao" THEN 1 ELSE 0 END) as devolvidos,
            MAX(data) as ultima_data'
        )
        ->join('alunos', 'alunos.id', '=', 'frequencias.aluno_id')
        ->groupBy('alunos.turma_id')
        ->get()
        ->keyBy('turma_id');

        return view('secretaria.frequencia.index', compact('turmas', 'resumo'));
    }

    public function turma(Turma $turma, Request $request)
    {
        $status = $request->query('status', 'pendente_aprovacao');

        $registros = Frequencia::whereHas('aluno', fn ($query) => $query->where('turma_id', $turma->id))
            ->when($status, fn ($query) => $query->where('status', $status))
            ->selectRaw(
                'data,
                COUNT(*) as total,
                SUM(CASE WHEN status_presenca = "presente" THEN 1 ELSE 0 END) as presentes,
                SUM(CASE WHEN status_presenca = "falta" THEN 1 ELSE 0 END) as faltas,
                SUM(CASE WHEN status_presenca = "atraso" THEN 1 ELSE 0 END) as atrasos,
                SUM(CASE WHEN status_presenca = "saida_antecipada" THEN 1 ELSE 0 END) as saidas,
                SUM(CASE WHEN status = "pendente_aprovacao" THEN 1 ELSE 0 END) as pendentes,
                SUM(CASE WHEN status = "aprovado" THEN 1 ELSE 0 END) as aprovadas,
                SUM(CASE WHEN status = "devolvido_correcao" THEN 1 ELSE 0 END) as devolvidos'
            )
            ->groupBy('data')
            ->orderBy('data', 'desc')
            ->paginate(15);

        return view('secretaria.frequencia.show', compact('turma', 'registros', 'status'));
    }

    public function detalhe(Turma $turma, string $data)
    {
        $frequencias = Frequencia::with(['aluno', 'lancadoPor'])
            ->whereHas('aluno', fn ($query) => $query->where('turma_id', $turma->id))
            ->whereDate('data', $data)
            // ->orderBy('aluno.nome')
            ->join('alunos', 'frequencias.aluno_id', '=', 'alunos.id')
->orderBy('alunos.nome')
            ->get();

        abort_if($frequencias->isEmpty(), 404);

        $status = $frequencias->first()->status;

        return view('secretaria.frequencia.detalhes', compact('turma', 'data', 'frequencias', 'status'));
    }

    public function aprovarData(Turma $turma, string $data)
    {
        Frequencia::whereHas('aluno', fn ($query) => $query->where('turma_id', $turma->id))
            ->whereDate('data', $data)
            ->where('status', 'pendente_aprovacao')
            ->update([
                'status' => 'aprovado',
                'status_aprovacao' => 'aprovado',
                'aprovado_secretaria_em' => now(),
                'aprovado_por' => Auth::id(),
                'motivo_devolucao' => null,
            ]);

        return redirect()->route('secretaria.frequencias.detalhes', [$turma, $data])
            ->with('success', 'Chamada aprovada para a turma.');
    }

    public function rejeitarData(Request $request, Turma $turma, string $data)
    {
        $request->validate([
            'motivo' => ['required', 'string', 'max:1000'],
        ]);

        Frequencia::whereHas('aluno', fn ($query) => $query->where('turma_id', $turma->id))
            ->whereDate('data', $data)
            ->where('status', 'pendente_aprovacao')
            ->update([
                'status' => 'devolvido_correcao',
                'status_aprovacao' => 'rejeitado',
                'motivo_devolucao' => $request->motivo,
                'aprovado_por' => Auth::id(),
            ]);

        return redirect()->route('secretaria.frequencias.detalhes', [$turma, $data])
            ->with('success', 'Chamada devolvida para correção pelo professor.');
    }

    public function aprovar(Frequencia $frequencia)
    {
        if ($frequencia->status !== 'pendente_aprovacao') {
            return back()->withErrors(['status' => 'Apenas frequências pendentes podem ser aprovadas.']);
        }

        $frequencia->update([
            'status' => 'aprovado',
            'status_aprovacao' => 'aprovado',
            'aprovado_secretaria_em' => now(),
            'aprovado_por' => Auth::id(),
            'motivo_devolucao' => null,
        ]);

        return back()->with('success', 'Frequência liberada para a empresa.');
    }

    public function rejeitar(Request $request, Frequencia $frequencia)
    {
        $request->validate([
            'motivo' => ['required', 'string', 'max:1000'],
        ]);

        if ($frequencia->status !== 'pendente_aprovacao') {
            return back()->withErrors(['status' => 'Apenas frequências pendentes podem ser devolvidas.']);
        }

        $frequencia->update([
            'status' => 'devolvido_correcao',
            'status_aprovacao' => 'rejeitado',
            'motivo_devolucao' => $request->motivo,
            'aprovado_por' => Auth::id(),
        ]);

        return back()->with('success', 'Frequência devolvida para correção pelo professor.');
    }
}
