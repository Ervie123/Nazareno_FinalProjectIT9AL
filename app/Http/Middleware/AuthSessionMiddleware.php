<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthSessionMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Session::get('auth_user')) {
            return redirect()->route('auth.login');
        }
        return $next($request);
    }
}
