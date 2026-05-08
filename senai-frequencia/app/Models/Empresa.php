<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $fillable = [
        'nome',
        'cnpj',
        'responsavel',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function alunos()
    {
        return $this->hasMany(Aluno::class);
    }
}