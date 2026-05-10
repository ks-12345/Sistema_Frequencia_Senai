<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaidaAntecipada extends Model
{
    protected $table = 'saidas_antecipadas';

    protected $fillable = [
        'aluno_id',
        'solicitado_por_id',
        'validado_por_id',
        'horario_saida',
        'motivo',
        'status',
        'observacao_secretaria',
        'validado_em',
    ];

    protected $casts = [
        'horario_saida' => 'datetime',
        'validado_em'   => 'datetime',
    ];

    public function aluno()
    {
        return $this->belongsTo(Aluno::class);
    }

    public function solicitadoPor()
    {
        return $this->belongsTo(User::class, 'solicitado_por_id');
    }

    public function validadoPor()
    {
        return $this->belongsTo(User::class, 'validado_por_id');
    }

    public function isPendente(): bool
    {
        return $this->status === 'pendente';
    }
}