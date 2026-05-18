<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use App\Models\DiarioAula;
use App\Models\TeacherSubstitutionLog;
use App\Models\Turma;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiarioAulaController extends Controller
{
    private function getTurmasDoUsuario()
    {
        $user = Auth::user();
        $mode = session('teacher_acting_mode');

        if (!$mode) {
            return collect();
        }

        if ($mode === 'substituto') {
            $log = TeacherSubstitutionLog::where('teacher_id', $user->id)
                ->where('status', 'ativa')
                ->find(session('teacher_substitution_log_id'));

            if (!$log) {
                session()->forget(['teacher_acting_mode', 'teacher_substitution_log_id', 'teacher_substitution_class_id']);
                return collect();
            }

            return Turma::where('id', $log->class_id)->get();
        }

        return Turma::where('professor_id', $user->id)->get();
    }

    public function index()
    {
        if (!session('teacher_acting_mode')) {
            return redirect()->route('professor.context.select');
        }

        $turmas = $this->getTurmasDoUsuario();

        return view('professor.diario.index', compact('turmas'));
    }

    public function turma(Turma $turma)
    {
        $turmas = $this->getTurmasDoUsuario();

        if (!$turmas->contains('id', $turma->id)) {
            abort(403);
        }

        $aulas = DiarioAula::where('turma_id', $turma->id)
            ->orderBy('data', 'desc')
            ->orderBy('aula_numero', 'desc')
            ->paginate(15);

        return view('professor.diario.turma', compact('turma', 'aulas'));
    }

    public function create(Turma $turma)
    {
        $turmas = $this->getTurmasDoUsuario();

        if (!$turmas->contains('id', $turma->id)) {
            abort(403);
        }

        if ($turma->isFinalizada()) {
            return redirect()->route('professor.diario.turma', $turma)
                             ->with('error', 'Turma finalizada. Não é possível adicionar aulas.');
        }

        // Próximo número de aula
        $ultimaAula = DiarioAula::where('turma_id', $turma->id)->max('aula_numero');
        $proximaAula = ($ultimaAula ?? 0) + 1;

        return view('professor.diario.create', compact('turma', 'proximaAula'));
    }

    public function store(Request $request, Turma $turma)
    {
        $turmas = $this->getTurmasDoUsuario();

        if (!$turmas->contains('id', $turma->id)) {
            abort(403);
        }

        $request->validate([
            'data'        => 'required|date',
            'titulo'      => 'required|string|max:255',
            'conteudo'    => 'required|string',
            'aula_numero' => 'required|integer|min:1',
        ]);

        DiarioAula::create([
            'turma_id'    => $turma->id,
            'professor_id'=> Auth::id(),
            'data'        => $request->data,
            'titulo'      => $request->titulo,
            'conteudo'    => $request->conteudo,
            'aula_numero' => $request->aula_numero,
        ]);

        return redirect()->route('professor.diario.turma', $turma)
                         ->with('success', 'Aula registrada no diário!');
    }

    public function edit(Turma $turma, DiarioAula $aula)
    {
        $turmas = $this->getTurmasDoUsuario();

        if (!$turmas->contains('id', $turma->id)) {
            abort(403);
        }

        if ((int) $aula->turma_id !== (int) $turma->id) {
            abort(404);
        }

        if ($turma->isFinalizada()) {
            return redirect()->route('professor.diario.turma', $turma)
                             ->with('error', 'Turma finalizada. Não é possível editar.');
        }

        return view('professor.diario.edit', compact('turma', 'aula'));
    }

    public function update(Request $request, Turma $turma, DiarioAula $aula)
    {
        $turmas = $this->getTurmasDoUsuario();

        if (!$turmas->contains('id', $turma->id)) {
            abort(403);
        }

        if ((int) $aula->turma_id !== (int) $turma->id) {
            abort(404);
        }

        $request->validate([
            'data'        => 'required|date',
            'titulo'      => 'required|string|max:255',
            'conteudo'    => 'required|string',
            'aula_numero' => 'required|integer|min:1',
        ]);

        $aula->update($request->only('data', 'titulo', 'conteudo', 'aula_numero'));

        return redirect()->route('professor.diario.turma', $turma)
                         ->with('success', 'Aula atualizada!');
    }

    public function destroy(Turma $turma, DiarioAula $aula)
    {
        $turmas = $this->getTurmasDoUsuario();

        if (!$turmas->contains('id', $turma->id)) {
            abort(403);
        }

        if ((int) $aula->turma_id !== (int) $turma->id) {
            abort(404);
        }

        $aula->delete();

        return redirect()->route('professor.diario.turma', $turma)
                         ->with('success', 'Aula removida do diário.');
    }
}
