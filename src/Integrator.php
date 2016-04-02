<?php

namespace Krustnic\Integrator;

class Integrator
{

    public function __construct()
    {

    }

    public function request( $systemName, $data = [], $apiPath = "/integrator/api/getToken" ) {
        if ( !$systemName ) return [];

        $systems = config("integrator.systems");

        if ( !isset( $systems[ $systemName ] ) ) return [
            "error" => "No such system in conig file"
        ];

        if ( !isset( $systems[ $systemName ][ "url" ] ) ) return [
            "error" => "No defined system URL"
        ];

        $url = $systems[ $systemName ][ "url" ].$apiPath;
        $optionsJSON = json_encode([
            "auth" => [
                "secret" => config("integrator.secret")
            ],
            "data" => $data
        ]);

        $ch = curl_init( $url );
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $optionsJSON);

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

}