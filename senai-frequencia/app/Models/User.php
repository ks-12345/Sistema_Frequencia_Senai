<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Aluno;
use App\Models\Turma;

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
        'cpf',
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

    public function aluno()
    {
        return $this->hasOne(Aluno::class);
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

    public function isSecretaria(): bool
    {
        return $this->role === 'secretaria';
    }

    public function solicitacoesSaidaComoProfessor()
    {
        return $this->hasMany(SolicitacaoSaida::class, 'professor_id');
    }

    public function analisesSaida()
    {
        return $this->hasMany(SolicitacaoSaida::class, 'analisado_por');
    }

    public function turmas()
{
    return $this->belongsToMany(Turma::class, 'professor_turma');
}

    public function substitutionLogs()
    {
        return $this->hasMany(TeacherSubstitutionLog::class, 'teacher_id');
    }

    public function substitutionsAsTitular()
    {
        return $this->hasMany(TeacherSubstitutionLog::class, 'substituted_teacher_id');
    }

}
