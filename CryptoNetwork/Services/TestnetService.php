<?php

namespace Modules\CryptoNetwork\Services;

class TestnetService extends BaseService implements CryptoNetworkServiceInterface
{
    public static function symbol(): string
    {
        return 'TESTNET';
    }

	protected function coinType(): int
	{
		return 1;
	}
}
