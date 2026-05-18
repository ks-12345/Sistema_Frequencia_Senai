<?php

namespace App\Exports;

use App\Models\TeacherSubstitutionLog;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TeacherSubstitutionLogsExport implements FromQuery, WithHeadings, WithMapping
{
    public function __construct(private readonly array $filters = [])
    {
    }

    public function query(): Builder
    {
        $query = TeacherSubstitutionLog::query()
            ->with(['substituteTeacher', 'substitutedTeacher', 'turma'])
            ->orderByDesc('started_at');

        if (!empty($this->filters['teacher_id'])) {
            $query->where('teacher_id', $this->filters['teacher_id']);
        }

        if (!empty($this->filters['substituted_teacher_id'])) {
            $query->where('substituted_teacher_id', $this->filters['substituted_teacher_id']);
        }

        if (!empty($this->filters['turma_id'])) {
            $query->where('class_id', $this->filters['turma_id']);
        }

        if (!empty($this->filters['disciplina'])) {
            $disciplina = $this->filters['disciplina'];

            $query->whereHas('turma', function ($turmaQuery) use ($disciplina) {
                $turmaQuery->where('curso', 'like', '%' . $disciplina . '%');
            });
        }

        if (!empty($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }

        if (!empty($this->filters['data_inicio'])) {
            $query->whereDate('started_at', '>=', $this->filters['data_inicio']);
        }

        if (!empty($this->filters['data_fim'])) {
            $query->whereDate('started_at', '<=', $this->filters['data_fim']);
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'Professor Substituto',
            'Professor Titular',
            'Turma',
            'Disciplina',
            'Data',
            'Hora Inicio',
            'Hora Fim',
            'Total de Horas',
            'Status',
        ];
    }

    public function map($log): array
    {
        return [
            $log->substituteTeacher->name ?? '',
            $log->substitutedTeacher->name ?? '',
            $log->turma->nome ?? '',
            $log->turma->curso ?? '',
            $log->started_at?->format('d/m/Y'),
            $log->started_at?->format('H:i'),
            $log->ended_at?->format('H:i') ?? '',
            $log->total_hours ?? '',
            ucfirst($log->status),
        ];
    }
}
