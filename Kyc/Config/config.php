<?php

return [
    'name' => 'Kyc',

    'driver' => 'jibit',

    'providers' => [
        'jibit' => [
            'api_key' => env('JIBIT_API_KEY'),
            'secret' => env('JIBIT_SECRET_KEY'),
            'base_url' => env('JIBIT_BASE_URL')
        ]
    ]
];
