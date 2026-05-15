<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolicitacaoSaida extends Model
{
    protected $table = 'solicitacoes_saida';

    protected $fillable = [
        'aluno_id',
        'professor_id',
        'turma_id',
        'frequencia_id',
        'data',
        'horario_saida',
        'motivo',
        'observacoes',
        'apresentou_justificativa',
        'autorizado_saida',
        'status',
        'analisado_por',
        'data_analise',
    ];

    protected $casts = [
        'data' => 'date',
        'apresentou_justificativa' => 'boolean',
        'autorizado_saida' => 'boolean',
        'data_analise' => 'datetime',
    ];

    public const STATUS = ['pendente', 'em_analise', 'aprovado', 'recusado', 'falta_mantida', 'justificado'];

    public function aluno()
    {
        return $this->belongsTo(Aluno::class);
    }

    public function professor()
    {
        return $this->belongsTo(User::class, 'professor_id');
    }

    public function turma()
    {
        return $this->belongsTo(Turma::class);
    }

    public function frequencia()
    {
        return $this->belongsTo(Frequencia::class);
    }

    public function justificativas()
    {
        return $this->hasMany(Justificativa::class);
    }

    public function analisadoPor()
    {
        return $this->belongsTo(User::class, 'analisado_por');
    }

    public function historicos()
    {
        return $this->hasMany(HistoricoSolicitacaoSaida::class);
    }

    public function isPendente(): bool
    {
        return in_array($this->status, ['pendente', 'em_analise'], true);
    }
}
