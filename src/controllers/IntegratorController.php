<?php

namespace Krustnic\Integrator;

use Illuminate\Routing\Controller;

class IntegratorController extends Controller
{
    protected $integrator;

    public function __construct( Integrator $integrator )
    {
        $this->integrator = $integrator;
    }

    public function gates($token)
    {
        return $token;
    }

    public function getToken() {
        return "getToken";
    }
}