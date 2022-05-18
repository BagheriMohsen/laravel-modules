<?php

return [
    'name' => 'Sms',

    'driver' => env('SMS_DRIVER', 'kavenegar'),

    'have_log' => env('SMS_HAVE_LOG', true),

    'provider_services' => [
        'kavenegar' => \Modules\Sms\Services\KavenegarService::class,
        'ghasedak' => \Modules\Sms\Services\GhasedakService::class,
        'meli_payamak' => \Modules\Sms\Services\MeliPayamakService::class
    ],

    'status' => env('SMS_STATUS', false),

    'call' => [
        'status' => env('CALL_STATUS', false)
    ],

    'kavenegar' => [
        'api_key' => env('KAVENEGAR_API_KEY'),
        'sender' => env('KAVENEGAR_SENDER')
    ],

    'ghasedak' => [
        'api_key' => env('GHASEDAK_API_KEY'),
        'sender' => env('GHASEDAK_SENDER')
    ],

    'meli_payamak' => [
        'username' => env('MELI_PAYAMANK_USERNAME'),
        'password' => env('MELI_PAYAMANK_PASSWORD'),
        'sender' => env('MELI_PAYAMANK_SENDER')
    ]
];
