<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Justificativa extends Model
{
    protected $fillable = [
        'solicitacao_saida_id',
        'descricao',
        'arquivo',
        'status',
        'analisado_por',
        'data_analise',
    ];

    protected $casts = [
        'data_analise' => 'datetime',
    ];

    public function solicitacao()
    {
        return $this->belongsTo(SolicitacaoSaida::class, 'solicitacao_saida_id');
    }

    public function analisadoPor()
    {
        return $this->belongsTo(User::class, 'analisado_por');
    }
}
