<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TentativaSaida extends Model
{
    protected $table = 'tentativas_saida';

    protected $fillable = [
        'aluno_id',
        'data_hora',
        'resultado',
        'motivo_bloqueio',
    ];

    protected $casts = [
        'data_hora' => 'datetime',
    ];

    public function aluno()
    {
        return $this->belongsTo(Aluno::class);
    }
}
