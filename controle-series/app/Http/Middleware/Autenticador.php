<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class Autenticador
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->is('entrar', 'registrar') && !Auth::check()){
            return redirect('/entrar'); // Redireciona para a página de login
        }
         return $next($request);
    }
}
