<?php

namespace Krustnic\Integrator\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Str;

class IntegratorTokens extends Model
{
    public static function generateToken( $userId, $url, $lifetime = 60 ) {
        // Remove expired tokens
        $expireDate = Carbon::now()->subSeconds($lifetime);
        IntegratorTokens::where( "created_at", "<=", $expireDate )->delete();
        //

        //Create unique token
        do {
            // Hash::make in some cases return not escaped URL string
            $tokenString = Str::random(255);
        } while ( IntegratorTokens::where("token", $tokenString)->first() );

        $token = new IntegratorTokens();
        $token->user_id  = $userId;
        $token->token    = $tokenString;
        $token->path     = $url;
        $token->lifetime = $lifetime;
        $token->save();

        return $tokenString;
    }

    public static function isValid( $tokenString ) {
        $token = static::where("token", $tokenString)->first();

        if ( !$token ) return FALSE;
        if ( $token->created_at <= Carbon::now()->subSeconds($token->lifetime) ) {
            // Remove expired token
            $token->delete();
            return FALSE;
        }

        return $token;
    }
}
