<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use STS\JWT\JWTFacade;

class MakeSureAdmin
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
        if($request->hasCookie( config('app.name').'_admin' ) && $this->validCookie() ) {
            return $next($request);
        }
        auth()->logout();
        return response()->redirectTo('/admin/auth');
    }

    private function validCookie()
    {
        if( $cookie =  request()->cookie(config('app.name').'_admin' )) {
            try {
                $token = JWTFacade::parse($cookie);

                auth()->login(new User([
                    'name' => $token->get('phone')
                ]));

                return $token->validate('');
            } catch (\Throwable $th) {
                //throw $th;
            }
        }

        return false;
    }
}
