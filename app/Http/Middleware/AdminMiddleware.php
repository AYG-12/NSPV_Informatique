<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::check()) {
            return redirect('/connexion')->with('error', 'Connectez-vous pour accéder à cette page.');
        }

        if (! Auth::user()->isAdmin()) {
            abort(403, 'Accès refusé. Vous n\'avez pas les droits administrateur.');
        }

        return $next($request);
    }
}
