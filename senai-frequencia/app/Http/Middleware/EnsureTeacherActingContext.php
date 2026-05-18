<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTeacherActingContext
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!session('teacher_acting_mode')) {
            return redirect()->route('professor.context.select');
        }

        return $next($request);
    }
}
