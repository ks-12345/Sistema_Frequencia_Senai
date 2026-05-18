<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use App\Models\TeacherSubstitutionLog;
use App\Models\Turma;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ActingContextController extends Controller
{
    public function select(): View
    {
        $activeSubstitution = $this->activeSubstitution();

        return view('professor.acting-context.select', compact('activeSubstitution'));
    }

    public function titular(Request $request): RedirectResponse
    {
        $this->finishActiveSubstitution($request);

        $request->session()->put('teacher_acting_mode', 'titular');
        $request->session()->forget([
            'teacher_substitution_log_id',
            'teacher_substitution_class_id',
            'teacher_substituted_teacher_id',
        ]);

        activity()
            ->causedBy(Auth::user())
            ->event('teacher_context_changed')
            ->log('Professor selecionou atuacao como titular.');

        return redirect()->route('professor.dashboard')
            ->with('success', 'Modo titular ativado.');
    }

    public function substituteForm(): View
    {
        $turmas = Turma::with('professor')
            ->where(function ($query) {
                $query->whereNull('status')->orWhere('status', '!=', 'finalizada');
            })
            ->orderBy('nome')
            ->get();

        $professores = User::where('role', 'professor')
            ->where('id', '!=', Auth::id())
            ->orderBy('name')
            ->get();

        return view('professor.acting-context.substitute', compact('turmas', 'professores'));
    }

    public function substitute(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'turma_id' => ['required', 'exists:turmas,id'],
            'substituted_teacher_id' => ['required', 'exists:users,id'],
            'started_at' => ['nullable', 'date', 'before_or_equal:now'],
        ]);

        $turma = Turma::findOrFail($data['turma_id']);

        if ((int) $turma->professor_id !== (int) $data['substituted_teacher_id']) {
            return back()
                ->withInput()
                ->withErrors(['substituted_teacher_id' => 'O professor titular selecionado nao corresponde a turma.']);
        }

        if ((int) $data['substituted_teacher_id'] === Auth::id()) {
            return back()
                ->withInput()
                ->withErrors(['substituted_teacher_id' => 'Um professor nao pode substituir a si mesmo.']);
        }

        $this->finishActiveSubstitution($request);

        $log = TeacherSubstitutionLog::create([
            'teacher_id' => Auth::id(),
            'substituted_teacher_id' => $data['substituted_teacher_id'],
            'class_id' => $turma->id,
            'subject_id' => null,
            'started_at' => $data['started_at'] ?? now(),
            'created_by' => Auth::id(),
            'status' => 'ativa',
        ]);

        $request->session()->put('teacher_acting_mode', 'substituto');
        $request->session()->put('teacher_substitution_log_id', $log->id);
        $request->session()->put('teacher_substitution_class_id', $turma->id);
        $request->session()->put('teacher_substituted_teacher_id', $data['substituted_teacher_id']);

        activity()
            ->performedOn($log)
            ->causedBy(Auth::user())
            ->withProperties([
                'turma_id' => $turma->id,
                'substituted_teacher_id' => $data['substituted_teacher_id'],
            ])
            ->event('teacher_substitution_started')
            ->log('Professor iniciou atuacao como substituto.');

        return redirect()->route('professor.dashboard')
            ->with('success', 'Modo substituto ativado e sessao registrada.');
    }

    public function finish(Request $request): RedirectResponse
    {
        $this->finishActiveSubstitution($request);
        $request->session()->put('teacher_acting_mode', 'titular');

        return redirect()->route('professor.dashboard')
            ->with('success', 'Substituicao encerrada.');
    }

    private function activeSubstitution(): ?TeacherSubstitutionLog
    {
        $id = session('teacher_substitution_log_id');

        if (!$id) {
            return null;
        }

        return TeacherSubstitutionLog::with(['turma', 'substitutedTeacher'])
            ->where('teacher_id', Auth::id())
            ->where('status', 'ativa')
            ->find($id);
    }

    private function finishActiveSubstitution(Request $request): void
    {
        $log = $this->activeSubstitution();

        if (!$log) {
            return;
        }

        $log->finish();

        activity()
            ->performedOn($log)
            ->causedBy(Auth::user())
            ->event('teacher_substitution_finished')
            ->log('Professor encerrou atuacao como substituto.');

        $request->session()->forget([
            'teacher_substitution_log_id',
            'teacher_substitution_class_id',
            'teacher_substituted_teacher_id',
        ]);
    }
}
