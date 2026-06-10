<?php

namespace App\Http\Middleware;

use App\Models\PageVisit;
use Closure;
use Illuminate\Http\Request;

class TrackPageVisit
{
    public function handle(Request $request, Closure $next)
    {
        // Ne compter que les vraies visites de page (GET uniquement, hors admin)
        if ($request->isMethod('GET') && !$request->is('welAdminnspv*')) {
            $today      = now()->toDateString();
            $sessionKey = 'visited_' . $today;

            if (!$request->session()->has($sessionKey)) {
                PageVisit::firstOrCreate(['date' => $today])->increment('count');
                $request->session()->put($sessionKey, true);
            }
        }

        return $next($request);
    }
}
