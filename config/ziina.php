<?php


return [
    /*
    |--------------------------------------------------------------------------
    | Ziina API Configuration
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials and configuration for the
    | Ziina payment gateway integration.
    |
    */

    // Ziina API URL
    'api_url' => env('ZIINA_API_URL', 'https://api-v2.ziina.com/api'),

    // Your Ziina API Key (Auth Token)
    'api_key' => env('ZIINA_API_KEY', ''),

    // Test Mode (true for testing, false for production)
    'test_mode' => env('ZIINA_TEST_MODE', true),

    // Webhook Secret (for verifying webhook signatures)
    'webhook_secret' => env('ZIINA_WEBHOOK_SECRET', ''),
];