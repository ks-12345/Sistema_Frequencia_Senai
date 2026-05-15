<?php

namespace App\Policies;

use App\Models\SolicitacaoSaida;
use App\Models\User;

class SolicitacaoSaidaPolicy
{
    public function view(User $user, SolicitacaoSaida $solicitacao): bool
    {
        if (in_array($user->role, ['admin', 'secretaria'], true)) {
            return true;
        }

        if ($user->role === 'professor') {
            return $solicitacao->professor_id === $user->id;
        }

        return $user->role === 'aluno' && $user->aluno?->id === $solicitacao->aluno_id;
    }

    public function update(User $user, SolicitacaoSaida $solicitacao): bool
    {
        return in_array($user->role, ['admin', 'secretaria'], true);
    }
}
