<?php

namespace Modules\CryptoNetwork\Services;

class BinanceService extends BaseService implements CryptoNetworkServiceInterface
{
    public static function symbol(): string
    {
        return 'BNB';
    }

	protected function coinType(): int
	{
		return 714;
	}

}
