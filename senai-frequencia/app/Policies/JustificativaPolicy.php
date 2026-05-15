<?php

namespace App\Policies;

use App\Models\Justificativa;
use App\Models\User;

class JustificativaPolicy
{
    public function view(User $user, Justificativa $justificativa): bool
    {
        if (in_array($user->role, ['admin', 'secretaria'], true)) {
            return true;
        }

        return $user->role === 'aluno'
            && $user->aluno?->id === $justificativa->solicitacao?->aluno_id;
    }

    public function update(User $user, Justificativa $justificativa): bool
    {
        return in_array($user->role, ['admin', 'secretaria'], true);
    }
}
