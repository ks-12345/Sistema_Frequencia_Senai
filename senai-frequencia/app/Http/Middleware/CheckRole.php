<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
public function handle(Request $request, Closure $next, string ...$roles): Response
{
    if (!Auth::check() || !in_array(Auth::user()->role, $roles)) {
        abort(403, 'Acesso negado.');
    }

    // Bloqueia substituto com acesso expirado
    $user = Auth::user();
    if ($user->is_substituto && $user->acesso_expira_em && $user->acesso_expira_em->isPast()) {
        Auth::logout();
        return redirect()->route('login')->with('error', 'Seu acesso temporário expirou.');
    }

    return $next($request);
}
}