<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiarioAula extends Model
{
    protected $table = 'diario_aulas';

    protected $fillable = [
        'turma_id',
        'professor_id',
        'data',
        'titulo',
        'conteudo',
        'aula_numero',
    ];

    protected $casts = [
        'data' => 'date',
    ];

    public function turma()
    {
        return $this->belongsTo(Turma::class);
    }

    public function professor()
    {
        return $this->belongsTo(User::class, 'professor_id');
    }
}