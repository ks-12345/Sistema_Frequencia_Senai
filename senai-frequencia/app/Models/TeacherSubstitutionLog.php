<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherSubstitutionLog extends Model
{
    protected $fillable = [
        'teacher_id',
        'substituted_teacher_id',
        'class_id',
        'subject_id',
        'started_at',
        'ended_at',
        'total_hours',
        'created_by',
        'status',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
        'total_hours' => 'decimal:2',
    ];

    public function substituteTeacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function substitutedTeacher()
    {
        return $this->belongsTo(User::class, 'substituted_teacher_id');
    }

    public function turma()
    {
        return $this->belongsTo(Turma::class, 'class_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function finish(): void
    {
        if ($this->ended_at) {
            return;
        }

        $endedAt = now();
        $minutes = max(0, $this->started_at->diffInMinutes($endedAt));

        $this->forceFill([
            'ended_at' => $endedAt,
            'total_hours' => round($minutes / 60, 2),
            'status' => 'encerrada',
        ])->save();
    }
}
