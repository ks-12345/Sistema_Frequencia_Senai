<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Frequencia extends Model
{
    protected $fillable = [
        'aluno_id',
        'lancado_por_id',
        'aprovado_por',
        'data',
        'status_presenca',
        'status_aprovacao',
        'observacao',

        // Fluxo Professor -> Secretaria -> Empresa
        'status',
        'enviado_secretaria_em',
        'aprovado_secretaria_em',
        'aprovado_por',
        'motivo_devolucao',
    ];


    protected $casts = [
        'data' => 'date',
        'enviado_secretaria_em' => 'datetime',
        'aprovado_secretaria_em' => 'datetime',
    ];


    public function aluno()
    {
        return $this->belongsTo(Aluno::class);
    }

    public function lancadoPor()
    {
        return $this->belongsTo(User::class, 'lancado_por_id');
    }

    public function aprovadoPor()
    {
        return $this->belongsTo(User::class, 'aprovado_por');
    }

    public function solicitacaoSaida()
    {
        return $this->hasOne(SolicitacaoSaida::class);
    }
}
