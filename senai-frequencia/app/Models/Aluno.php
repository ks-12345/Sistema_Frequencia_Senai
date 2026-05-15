<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\User;

class Aluno extends Model
{
    protected $fillable = [
        'nome',
        'matricula',
        'cpf',
        'email',
        'data_nascimento',
        'endereco',
        'qrcode_token',
        'turma_id',
        'empresa_id',
        'user_id',
    ];

    protected static function booted(): void
    {
        // Gera token único automaticamente ao criar aluno
        static::creating(function (Aluno $aluno) {
            $aluno->qrcode_token = Str::uuid();
        });
    }

    protected $casts = [
        'data_nascimento' => 'date',
    ];

    public function turma()
    {
        return $this->belongsTo(Turma::class);
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function frequencias()
    {
        return $this->hasMany(Frequencia::class);
    }

    public function solicitacoesSaida()
    {
        return $this->hasMany(SolicitacaoSaida::class);
    }

    public function tentativasSaida()
    {
        return $this->hasMany(TentativaSaida::class);
    }

    public function isMenorDeIdade(): bool
    {
        return $this->data_nascimento ? $this->data_nascimento->age < 18 : false;
    }
}
