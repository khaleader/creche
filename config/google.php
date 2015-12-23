<?php

return [
    /*
    |----------------------------------------------------------------------------
    | Google application name
    |----------------------------------------------------------------------------
    */
    'application_name' => '',

    /*
    |----------------------------------------------------------------------------
    | Google OAuth 2.0 access
    |----------------------------------------------------------------------------
    |
    | Keys for OAuth 2.0 access, see the API console at
    | https://developers.google.com/console
    |
    */
    'client_id'       => '548520090024-i8jmtdmdi5ijvj3mn2sbqe2u3a431gh6.apps.googleusercontent.com',
    'client_secret'   => 'IX-SilXd0ctCrKUX1a5oP9is',
    'redirect_uri'    => 'http://laravel.dev:8000/schools/boite',
    'scopes'          => ['https://mail.google.com'],
    'access_type'     => 'online',
    'approval_prompt' => 'auto',

    /*
    |----------------------------------------------------------------------------
    | Google developer key
    |----------------------------------------------------------------------------
    |
    | Simple API access key, also from the API console. Ensure you get
    | a Server key, and not a Browser key.
    |
    */
    'developer_key' => '',

    /*
    |----------------------------------------------------------------------------
    | Google service account
    |----------------------------------------------------------------------------
    |
    | Enable and set the information below to use assert credentials
    | Enable and leave blank to use app engine or compute engine.
    |
    */
    'service' => [
        /*
        | Enable service account auth or not.
        */
        'enable' => false,

        /*
        | Example xxx@developer.gserviceaccount.com
        */
        'account' => '',

        /*
        | Example ['https://www.googleapis.com/auth/cloud-platform']
        */
        'scopes' => [],

        /*
        | Path to key file
        | Example storage_path().'/key/google.p12'
        */
        'key' => '',
    ],
];
