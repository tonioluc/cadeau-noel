<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckSession
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('id_utilisateur')) {
            return redirect()->route('login.show');
        }

        return $next($request);
    }
}