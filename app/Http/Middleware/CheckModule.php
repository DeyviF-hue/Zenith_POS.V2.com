<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckModule
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $module): Response
    {
        if (!config("modulos.{$module}.habilitado", true)) {
            // Module is disabled
            abort(403, "El módulo '{$module}' se encuentra deshabilitado en la configuración del sistema.");
        }

        return $next($request);
    }
}
