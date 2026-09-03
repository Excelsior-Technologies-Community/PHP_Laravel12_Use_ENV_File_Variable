<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Original ENV Variables
    |--------------------------------------------------------------------------
    */

    'admin_email' => env(
        'ADMIN_EMAIL',
        'admin@example.com'
    ),

    'support_number' => env(
        'SUPPORT_NUMBER',
        '+91-00000-00000'
    ),

    'app_version' => env(
        'APP_VERSION',
        '1.0'
    ),

    /*
    |--------------------------------------------------------------------------
    | Feature 1: Feature Flags
    |--------------------------------------------------------------------------
    */

    'features' => [

        'dark_mode' => filter_var(
            env('FEATURE_DARK_MODE', false),
            FILTER_VALIDATE_BOOLEAN
        ),

        'analytics' => filter_var(
            env('FEATURE_ANALYTICS', false),
            FILTER_VALIDATE_BOOLEAN
        ),

        'chat' => filter_var(
            env('FEATURE_CHAT', false),
            FILTER_VALIDATE_BOOLEAN
        ),
    ],

    /*
    |--------------------------------------------------------------------------
    | Feature 2: Maintenance Mode
    |--------------------------------------------------------------------------
    */

    'maintenance' => [

        'enabled' => filter_var(
            env('MAINTENANCE_MODE', false),
            FILTER_VALIDATE_BOOLEAN
        ),

        'message' => env(
            'MAINTENANCE_MESSAGE',
            'We are under maintenance. Please check back soon.'
        ),
    ],

    /*
    |--------------------------------------------------------------------------
    | Feature 5: Dynamic Theme
    |--------------------------------------------------------------------------
    */

    'theme' => [

        'color' => env(
            'APP_THEME_COLOR',
            '#0d6efd'
        ),

        'name' => env(
            'APP_THEME_NAME',
            'Blue'
        ),
    ],

    /*
    |--------------------------------------------------------------------------
    | Feature 6: API Keys
    |--------------------------------------------------------------------------
    */

    'api_key' => env(
        'API_KEY',
        ''
    ),

    'api_secret' => env(
        'API_SECRET',
        ''
    ),

    /*
    |--------------------------------------------------------------------------
    | Feature 4: Missing ENV Variables
    |--------------------------------------------------------------------------
    */

    'missing_env_vars' => [],
];