<?php

namespace Modules\CryptoNetwork\Services;

class LiteCoinService extends BaseService implements CryptoNetworkServiceInterface
{
    public static function symbol(): string
    {
        return 'LTC';
    }

	protected function coinType(): int
	{
		return 2;
	}
}
