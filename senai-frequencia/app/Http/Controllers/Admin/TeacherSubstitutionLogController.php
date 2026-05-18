<?php

namespace App\Http\Controllers\Admin;

use App\Exports\TeacherSubstitutionLogsExport;
use App\Http\Controllers\Controller;
use App\Models\TeacherSubstitutionLog;
use App\Models\Turma;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class TeacherSubstitutionLogController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->only([
            'teacher_id',
            'substituted_teacher_id',
            'turma_id',
            'disciplina',
            'status',
            'data_inicio',
            'data_fim',
        ]);

        $logs = $this->filteredQuery($filters)
            ->with(['substituteTeacher', 'substitutedTeacher', 'turma'])
            ->paginate(15)
            ->withQueryString();

        $professores = User::where('role', 'professor')->orderBy('name')->get();
        $turmas = Turma::orderBy('nome')->get();

        return view('admin.substitutos.index', compact('logs', 'professores', 'turmas', 'filters'));
    }

    public function export(Request $request)
    {
        $filters = $request->validate([
            'teacher_id' => ['nullable', 'exists:users,id'],
            'substituted_teacher_id' => ['nullable', 'exists:users,id'],
            'turma_id' => ['nullable', 'exists:turmas,id'],
            'disciplina' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', 'in:ativa,encerrada,cancelada'],
            'data_inicio' => ['nullable', 'date'],
            'data_fim' => ['nullable', 'date', 'after_or_equal:data_inicio'],
        ]);

        return Excel::download(
            new TeacherSubstitutionLogsExport($filters),
            'substituicoes_professores.xlsx'
        );
    }

    private function filteredQuery(array $filters)
    {
        $query = TeacherSubstitutionLog::query()->orderByDesc('started_at');

        if (!empty($filters['teacher_id'])) {
            $query->where('teacher_id', $filters['teacher_id']);
        }

        if (!empty($filters['substituted_teacher_id'])) {
            $query->where('substituted_teacher_id', $filters['substituted_teacher_id']);
        }

        if (!empty($filters['turma_id'])) {
            $query->where('class_id', $filters['turma_id']);
        }

        if (!empty($filters['disciplina'])) {
            $query->whereHas('turma', function ($turmaQuery) use ($filters) {
                $turmaQuery->where('curso', 'like', '%' . $filters['disciplina'] . '%');
            });
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['data_inicio'])) {
            $query->whereDate('started_at', '>=', $filters['data_inicio']);
        }

        if (!empty($filters['data_fim'])) {
            $query->whereDate('started_at', '<=', $filters['data_fim']);
        }

        return $query;
    }
}
