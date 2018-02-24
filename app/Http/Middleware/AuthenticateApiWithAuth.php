<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;

class AuthenticateApiWithAuth
{
    public function handle($request, Closure $next, $guard = null)
    {
        if ( ! Auth::guard($guard)->check()) {
            return response()->json((object)[])->setStatusCode(401);
        }

        return $next($request);
    }

}