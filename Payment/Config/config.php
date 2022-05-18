<?php

return [
    'name' => 'Payment',

    'driver' => env('PAYMENT_DRIVER', 'vandar'),

    'service_classes' => [
        'idpay' => \Modules\Payment\Services\PaymentGateway\IdPayService::class,
        'jibit' => \Modules\Payment\Services\PaymentGateway\JibitService::class,
        'vandar' => \Modules\Payment\Services\PaymentGateway\VandarService::class,
        'zibal' => \Modules\Payment\Services\PaymentGateway\ZibalService::class,
        'zarinpal' => \Modules\Payment\Services\PaymentGateway\ZarinpalService::class
    ],

    'payment_callback_url' => env('PAYMENT_CALLBACK_URL'),

    'callback_to_front' => env('PAYMENT_CALLBACK_TO_FRONT'),

    'gateways' => [
        'zarinpal' => [
            'merchant_id' => env('ZARINPAL_MERCHANT_ID'),
        ],
        'vandar' => [
            'api_key' => env('VANDAR_API_KEY')
        ],
        'idpay' => [
            'api_key' => env('IDPAY_API_KEY'),
            'sandbox' => env('IDPAY_SAND_BOX')
        ],
        'zibal' => [
            'merchant_id' => env('ZIBAL_MERCHANT_ID'),
            'send_link_to_mobile' => env('ZIBAL_SEND_LINK_TO_MOBILE', false)
        ]
    ]
];
