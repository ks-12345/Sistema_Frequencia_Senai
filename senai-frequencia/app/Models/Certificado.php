<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificado extends Model
{
    protected $fillable = [
        'aluno_id',
        'turma_id',
        'codigo',
        'percentual_presenca',
        'carga_horaria',
        'data_conclusao',
    ];

    protected $casts = [
        'data_conclusao' => 'date',
    ];

    public function aluno()
    {
        return $this->belongsTo(Aluno::class);
    }

    public function turma()
    {
        return $this->belongsTo(Turma::class);
    }
}