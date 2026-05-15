<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoricoSolicitacaoSaida extends Model
{
    protected $table = 'historico_solicitacoes_saida';

    protected $fillable = [
        'solicitacao_saida_id',
        'user_id',
        'acao',
        'descricao',
    ];

    public function solicitacao()
    {
        return $this->belongsTo(SolicitacaoSaida::class, 'solicitacao_saida_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
