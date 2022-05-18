<?php

use Modules\CryptoNetwork\Services\BinanceService;
use Modules\CryptoNetwork\Services\BinanceSmartChainService;
use Modules\CryptoNetwork\Services\BitcoinService;
use Modules\CryptoNetwork\Services\ByteTradeService;
use Modules\CryptoNetwork\Services\CardanoService;
use Modules\CryptoNetwork\Services\DogeService;
use Modules\CryptoNetwork\Services\EtcService;
use Modules\CryptoNetwork\Services\EthService;
use Modules\CryptoNetwork\Services\LiteCoinService;
use Modules\CryptoNetwork\Services\PolkadotService;
use Modules\CryptoNetwork\Services\TestnetService;
use Modules\CryptoNetwork\Services\TronService;

return [
    'name' => 'CryptoNetwork',

    'networks' => [
        BitcoinService::symbol() => BitcoinService::class,
        BinanceService::symbol() => BinanceService::class,
        BinanceSmartChainService::symbol() => BinanceSmartChainService::class,
        ByteTradeService::symbol() => ByteTradeService::class,
        CardanoService::symbol() => CardanoService::class,
        DogeService::symbol() => DogeService::class,
        EtcService::symbol() => EtcService::class,
        EthService::symbol() => EthService::class,
        LiteCoinService::symbol() => LiteCoinService::class,
        PolkadotService::symbol() => PolkadotService::class,
        TestnetService::symbol() => TestnetService::class,
        TronService::symbol() => TronService::class,
    ]
];
