<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Resend, Postmark, AWS, and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    // Mock token configuration for bearer token authentication.
    'auth' => [
        'mock_token' => env('MOCK_TOKEN', 'mock-token'),
    ],

    // Integrasi D-1 (API 7, API-K01-07). mode: mock (data/ui_seed.json) atau real (panggil D-1).
    'd1' => [
        'mode' => env('D1_MODE', 'mock'),
        'base_url' => env('D1_BASE_URL', 'http://localhost:3000/api/v1'),
        'timeout' => (int) env('D1_TIMEOUT', 3),
        'token' => env('D1_TOKEN', env('MOCK_TOKEN', 'mock-token')),
    ],

    // Integrasi F-1 (Identitas & Hak Akses). mode: mock (MOCK_TOKEN) atau real (verifikasi JWT HS256).
    'f1' => [
        'mode' => env('F1_MODE', 'mock'),
        'base_url' => env('F1_BASE_URL', 'http://localhost:4100'),
        'jwt_secret' => env('F1_JWT_SECRET', 'ganti-dengan-rahasia-acak-minimal-32-karakter'),
    ],

    // Integrasi F-2 (Master SDM & Tenaga Ahli). mode: mock atau real (panggil API-K02-17).
    'f2' => [
        'mode' => env('F2_MODE', 'mock'),
        'base_url' => env('F2_BASE_URL', 'http://localhost:8080/api/v1'),
        'timeout' => (int) env('F2_TIMEOUT', 3),
        'token' => env('F2_TOKEN', 'token-coo'),
    ],

];
