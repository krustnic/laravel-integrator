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
        $auth = $this->getAuthParameters();

        if ( !$auth || $auth["auth"]["secret"] != config("integrator.secret") ) return (new Response([], 401));

        return $next($request);
    }

    private function getAuthParameters() {
        $auth = json_decode( file_get_contents("php://input"), true );

        if ( !isset( $auth["auth"] ) ) return FALSE;
        if ( !isset( $auth["auth"]["secret"] ) ) return FALSE;

        return $auth;
    }

}