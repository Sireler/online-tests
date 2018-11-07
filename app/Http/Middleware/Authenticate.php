<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{

    public function handle($request, Closure $next, ...$guards)
    {
        if (collect($guards)->contains('api')) {
            if (Auth::guard('api')->guest()) {
                return response()->json(['status' => 'Unauthorized'], 401);
            } else {
                return $next($request);
            }
        } else {
            parent::handle($request, $next, $guards);
        }
    }
}
