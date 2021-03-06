<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use STS\JWT\JWTFacade;

class ApiAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $option = null)
    {

        
        if( $request->hasHeader('Authorization') ) {
            try {
                $token = JWTFacade::parse($request->header('authorization'))->validate("");
                // dd($token->getPayload());
                $request->offsetSet('auth', $token);
                return $next($request);
                // if( $option == 'post-otp' && $token->get('otp-verified') == true ) {
                // } else {
                    // throw new AuthenticationException("OTP is not verified.");
                // }
                //code...
            } catch (\Throwable $th) {
                //throw $th;
                // dd($th);
            }
        }

        throw new AuthenticationException("You are not authenticated.");
    }
}
