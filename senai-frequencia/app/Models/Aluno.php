<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Aluno extends Model
{
    protected $fillable = ['nome', 'matricula', 'qrcode_token', 'turma_id', 'empresa_id'];

    protected static function booted(): void
    {
        // Gera token único automaticamente ao criar aluno
        static::creating(function (Aluno $aluno) {
            $aluno->qrcode_token = Str::uuid();
        });
    }

    public function turma()
    {
        return $this->belongsTo(Turma::class);
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function frequencias()
    {
        return $this->hasMany(Frequencia::class);
    }
}