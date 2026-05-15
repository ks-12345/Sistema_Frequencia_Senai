<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Frequencia extends Model
{
    protected $fillable = [
        'aluno_id',
        'lancado_por_id',
        'aprovado_por_id',
        'data',
        'status_presenca',
        'status_aprovacao',
        'observacao',
    ];

    protected $casts = [
        'data' => 'date',
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
        return $this->belongsTo(User::class, 'aprovado_por_id');
    }

    public function solicitacaoSaida()
    {
        return $this->hasOne(SolicitacaoSaida::class);
    }
}
