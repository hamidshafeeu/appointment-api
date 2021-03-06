<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    
    'dhifaau' => [
        'token' => env('DHIFAAU_TOKEN'),
        'url' => env('DHIFAAU_URL'),
    ],

    'sms' => [
        'token' => env('SMS_TOKEN'),
        'endpoint' => env('SMS_ENDPOINT'),
    ],
    
    'pubsub' => [
        'project' => env('GCP_PROJECT'),
        'auth' => env('GCP_AUTH_FILE'),
    ],
    
    'dhifaau' => [
        'url' => env('DHIFAAU_URL'),
        'token' => env('DHIFAAU_TOKEN'),
    ],
    
    'ob' => [
        'url' => env('OB_URL'),
        'token' => env('OB_TOKEN'),
    ],
    
    'nazi_api' => [
        'url' => env('NAZI_API_URL'),
        'token' => env('NAZI_API_TOKEN'),
    ],
    
    'discord_bot' => [
        'webhook' => env('BOT_WEBHOOK'),
    ],

];
