<?php

namespace Modules\CryptoNetwork\Services;

class BitcoinService extends BaseService implements CryptoNetworkServiceInterface
{
    public static function symbol(): string
    {
        return 'BTC';
    }

    public function coinType(): int
    {
       return 0;
    }
}
