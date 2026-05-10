<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Turma extends Model
{
    protected $fillable = ['nome', 'curso', 'periodo', 'professor_id', 'status', 'finalizada_em'];

    protected $casts = [
        'finalizada_em' => 'datetime',
    ];

    public function professor()
    {
        return $this->belongsTo(User::class, 'professor_id');
    }

    public function alunos()
    {
        return $this->hasMany(Aluno::class);
    }

    public function substitutos()
    {
        return $this->belongsToMany(User::class, 'professor_turma');
    }

    public function isFinalizada(): bool
    {
        return $this->status === 'finalizada';
    }
}