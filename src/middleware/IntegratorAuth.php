<?php

namespace Krustnic\Integrator;

use Auth;
use Closure;
use Illuminate\Http\Response;

class IntegratorAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ( !Auth::onceBasic() ) {
            $user = Auth::user();

            if ( $user->email == config("integrator.username") ) {
                return $next($request);
            }

            return (new Response([], 401));
        }

        return Auth::onceBasic();
    }

}