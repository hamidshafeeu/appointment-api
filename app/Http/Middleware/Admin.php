<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if( $request->hasHeader('authorization') && $request->header('authorization') == config('app.admin_token') ) {
            return $next($request);
        }

        throw new AuthenticationException("Nop! Dont...");
    }
}
