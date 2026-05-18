<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        return redirect()->intended($this->redirectByRole());
    }

private function redirectByRole(): string
{
    return match(Auth::user()->role) {
        'admin'      => route('admin.dashboard'),
        'professor'  => route('professor.context.select'),
        'empresa'    => route('empresa.dashboard'),
        'aluno'      => route('aluno.dashboard'),
        'secretaria' => route('secretaria.saidas.index'),
        default      => '/',
    };
}

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
