<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use App\Models\TeacherSubstitutionLog;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (!session('teacher_acting_mode')) {
            return redirect()->route('professor.context.select');
        }

        $activeSubstitution = null;

        if (session('teacher_acting_mode') === 'substituto') {
            $activeSubstitution = TeacherSubstitutionLog::with(['turma', 'substitutedTeacher'])
                ->where('teacher_id', Auth::id())
                ->where('status', 'ativa')
                ->find(session('teacher_substitution_log_id'));

            if (!$activeSubstitution) {
                session()->forget(['teacher_acting_mode', 'teacher_substitution_log_id', 'teacher_substitution_class_id']);
                return redirect()->route('professor.context.select')
                    ->with('error', 'Selecione novamente sua atuacao.');
            }
        }

        return view('professor.dashboard', compact('activeSubstitution'));
    }
}
