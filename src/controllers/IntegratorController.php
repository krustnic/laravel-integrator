<?php

namespace Krustnic\Integrator;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Krustnic\Integrator\Models\IntegratorTokens;

class IntegratorController extends Controller
{
    protected $integrator;
    protected $UserClassName, $UsersIdField;

    public function __construct( Integrator $integrator )
    {
        $this->integrator = $integrator;
        $this->UserClassName = config("integrator.users_class");
        $this->UsersIdField  = config("integrator.users_id_field");
    }

    /**
     * Get token and redirect user to target location
     * After redirect token is removed
     * @param $token
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function gates($token)
    {
        $token = IntegratorTokens::isValid( $token );

        if ( !$token ) {
            return View::make('integrator::onerror');
        }

        $user = new $this->UserClassName;
        $targetUser     = $user->where( $this->UsersIdField, $token->user_id )->first();
        $redirectToPath = $token->path;

        // Remove used token
        $token->delete();

        Auth::login( $targetUser );

        return redirect( $redirectToPath );
    }

    /**
     * Get request with ["data"]["username"]
     * Generate and create token in database for this user
     * with lifetime for 60 seconds
     *
     * @return mixed
     */
    public function getToken() {
        $data = json_decode( file_get_contents("php://input"), true );

        $username = $data["data"]["username"];

        // Create redirect path
        $location = isset( $data["data"]["url"] ) ? $data["data"]["url"] : "/";
        $location = substr( $location, 0, 1 ) == '/'? $location : "/".$location;
        //

        $user = new $this->UserClassName;

        $targetUser = $user::where( config("integrator.users_username_field"), $username )->first();

        $token = IntegratorTokens::generateToken( $targetUser->{$this->UsersIdField}, $location );

        return [
            "token" => $token
        ];
    }
}