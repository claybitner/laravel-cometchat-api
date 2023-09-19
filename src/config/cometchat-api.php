<?php

return [
    /*
    |--------------------------------------------------------------------------
    | CometChat API Key
    |--------------------------------------------------------------------------
    |
    | You can generate a rest api key for your app from the CometChat dashboard
    | and enter it here
    |
    */
    'api_key' => env('COMETCHAT_API_KEY', ''),

    /*
    |--------------------------------------------------------------------------
    | CometChat API Version
    |--------------------------------------------------------------------------
    |
    | Add the CometChat API version here
    |
    */
    'api_version' => env('COMETCHAT_API_VERSION', 'v3'),

    /*
    |--------------------------------------------------------------------------
    | CometChat API Region
    |--------------------------------------------------------------------------
    |
    | Add the CometChat API region here
    |
    */
    'api_region' => env('COMETCHAT_API_REGION', 'us'),

    /*
    |--------------------------------------------------------------------------
    | App ID
    |--------------------------------------------------------------------------
    |
    | The App ID that was generated when you created your app from the dashboard.
    |
    */
    'app_id'  => config('COMETCHAT_APP_ID', ''),
];

