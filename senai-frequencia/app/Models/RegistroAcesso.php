<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistroAcesso extends Model
{
    protected $table = 'registros_acesso';

    protected $fillable = [
        'aluno_id',
        'tipo',
        'local',
        'registrado_em',
        'status',
        'observacao',
    ];

    protected $casts = [
        'registrado_em' => 'datetime',
    ];

    public function aluno()
    {
        return $this->belongsTo(Aluno::class);
    }
}