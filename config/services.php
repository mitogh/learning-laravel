<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env( 'MAILGUN_DOMAIN' ),
        'secret' => env( 'MAILGUN_SECRET' ),
        'endpoint' => env( 'MAILGUN_ENDPOINT', 'api.mailgun.net' ),
    ],

    'postmark' => [
        'token' => env( 'POSTMARK_TOKEN' ),
    ],

    'ses' => [
        'key' => env( 'AWS_ACCESS_KEY_ID' ),
        'secret' => env( 'AWS_SECRET_ACCESS_KEY' ),
        'region' => env( 'AWS_DEFAULT_REGION', 'us-east-1' ),
    ],

    'sparkpost' => [
        'secret' => env( 'SPARKPOST_SECRET' ),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env( 'STRIPE_KEY' ),
        'secret' => env( 'STRIPE_SECRET' ),
        'webhook' => [
            'secret' => env( 'STRIPE_WEBHOOK_SECRET' ),
            'tolerance' => env( 'STRIPE_WEBHOOK_TOLERANCE', 300 ),
        ],
    ],

    'google' => [
        'client_id' => env( 'GOOGLE_CLIENT_ID' ),
        'client_secret' => env( 'GOOGLE_CLIENT_SECRET' ),
        'redirect' => env( 'GOOGLE_LOGIN_REDIRECT' ),
        'suite_domain' => env( 'GOOGLE_SUITE_DOMAIN' ),
        'application' => [
            'key' => env( 'GOOGLE_KEY' ),
            'secret' => env( 'GOOGLE_SECRET' ),
            'credentials' => env( 'GOOGLE_APPLICATION_CREDENTIALS' ),
            'redirect' => env( 'GOOGLE_REDIRECT_URI' ),
            'impersonation' => env( 'GOOGLE_USER_IMPERSONATION' ),
        ],
    ],

    'bamboo' => [
        'api' => [
            'disabled' => env( 'BAMBOO_API_DISABLED', false ),
            'key' => env( 'BAMBOO_API_KEY' ),
            'domain' => env( 'BAMBOO_API_DOMAIN' ),
            'path' => env( 'BAMBOO_API_PATH' ),
        ]
    ],

    'tribe' => [
        'sheets' => [
            'allocation' => env( 'TRIBE_ALLOCATION_SHEET_ID', '' ),
        ],
    ],
];
