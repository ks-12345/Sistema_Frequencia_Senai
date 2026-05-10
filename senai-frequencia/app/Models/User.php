<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use Notifiable, HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'empresa_id',
        'is_substituto',
        'acesso_expira_em',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'acesso_expira_em'  => 'datetime',
        'is_substituto'     => 'boolean',
    ];

    public function empresa()
    {
        return $this->belongsTo(\App\Models\Empresa::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isProfessor(): bool
    {
        return $this->role === 'professor';
    }

    public function isEmpresa(): bool
    {
        return $this->role === 'empresa';
    }

    public function turmas()
{
    return $this->belongsToMany(Turma::class, 'professor_turma');
}

}