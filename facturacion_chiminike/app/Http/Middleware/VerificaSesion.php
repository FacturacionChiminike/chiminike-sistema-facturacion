<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerificaSesion
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('usuario') || !session()->has('token')) {
            return redirect('/logn')->with('error', 'Oops... Parece que no tienes permiso o tu sesión expiró. Inicia sesión para seguir.');
        }

        return $next($request);
    }
}
