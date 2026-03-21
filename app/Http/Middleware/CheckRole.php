<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // El rol developer tiene acceso a todo el sistema
        if ($user->hasRole('developer')) {
            return $next($request);
        }

        // Si el usuario tiene alguno de los roles permitidos
        if ($user->hasAnyRole($roles)) {
            return $next($request);
        }

        abort(403, 'No tienes permisos suficientes para acceder a esta sección.');
    }
}
