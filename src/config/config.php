<?php

return [

    /**
     * Secret string to authenticate laravel applications between each other
     */
    "secret" => "",

    /**
     * System names and it's URLs
     */
    "systems" => [
        "example" => [
            "url" => "http://example.com"
        ]
    ],

    /**
     * Field name for table 'users' for current project
     */
    "users_username_field" => "email",

    /**
     * Field name for 'users' table primary key
     */
    "users_id_field" => "id",

    /**
     * Class for User model
     */
    "users_class" => App\User::class,

];