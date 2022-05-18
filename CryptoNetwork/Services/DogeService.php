<?php

namespace Modules\CryptoNetwork\Services;

class DogeService extends BaseService implements CryptoNetworkServiceInterface
{
    public static function symbol(): string
    {
        return 'DOGE';
    }

	protected function coinType(): int
	{
		return 3;
	}
}
