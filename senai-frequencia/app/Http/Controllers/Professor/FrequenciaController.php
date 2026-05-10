<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use App\Models\Turma;
use App\Models\Frequencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrequenciaController extends Controller
{
    private function getTurmasDoUsuario()
    {
        $user = Auth::user();

        if ($user->is_substituto) {
            // Substituto: busca turmas vinculadas pela tabela pivot
            return $user->turmas;
        }

        // Professor titular: busca turmas pelo professor_id
        return Turma::where('professor_id', $user->id)->get();
    }

    public function index()
    {
        $turmas = $this->getTurmasDoUsuario();
        return view('professor.frequencia.index', compact('turmas'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'turma_id'      => 'required|exists:turmas,id',
            'data'          => 'required|date',
            'frequencias'   => 'required|array',
            'frequencias.*' => 'required|in:presente,falta,atraso',
        ]);

        $user            = Auth::user();
        $statusAprovacao = $user->is_substituto ? 'pendente' : 'aprovado';

        foreach ($request->frequencias as $alunoId => $status) {
            Frequencia::updateOrCreate(
                [
                    'aluno_id' => $alunoId,
                    'data'     => $request->data,
                ],
                [
                    'lancado_por_id'   => $user->id,
                    'status_presenca'  => $status,
                    'status_aprovacao' => $statusAprovacao,
                    'observacao'       => $request->observacoes[$alunoId] ?? null,
                ]
            );
        }

        return redirect()->route('professor.frequencia.index')
                         ->with('success', 'Frequência lançada com sucesso!');
    }

    public function pendentes()
    {
        $turmasIds = Turma::where('professor_id', Auth::id())->pluck('id');

        $frequencias = Frequencia::with(['aluno.turma', 'lancadoPor'])
            ->where('status_aprovacao', 'pendente')
            ->whereHas('aluno', function ($q) use ($turmasIds) {
                $q->whereIn('turma_id', $turmasIds);
            })
            ->orderBy('data', 'desc')
            ->get();

        return view('professor.frequencia.pendentes', compact('frequencias'));
    }

    public function aprovar(Frequencia $frequencia)
    {
        $frequencia->update([
            'status_aprovacao' => 'aprovado',
            'aprovado_por_id'  => Auth::id(),
        ]);

        return back()->with('success', 'Frequência aprovada!');
    }

    public function rejeitar(Frequencia $frequencia)
    {
        $frequencia->update([
            'status_aprovacao' => 'rejeitado',
            'aprovado_por_id'  => Auth::id(),
        ]);

        return back()->with('success', 'Frequência rejeitada!');
    }

    public function lancar(Turma $turma)
{
    $user   = Auth::user();
    $turmas = $this->getTurmasDoUsuario();

    if (!$turmas->contains('id', $turma->id)) {
        abort(403);
    }

    if ($turma->isFinalizada()) {
        return redirect()->route('professor.frequencia.index')
                         ->with('error', 'Esta turma está finalizada.');
    }

    $alunos = $turma->alunos;
    $data   = today()->toDateString();

    return view('professor.frequencia.lancar', compact('turma', 'alunos', 'data'));
}
}