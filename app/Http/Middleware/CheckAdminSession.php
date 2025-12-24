<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAdminSession
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('id_utilisateur')) {
            return redirect()->route('login.show');
        }
        if (session('id_utilisateur') != 1) {
                return redirect()->route('login.show');
        }
        return $next($request);
    }
}