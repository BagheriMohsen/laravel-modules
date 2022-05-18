<?php

namespace Modules\CryptoNetwork\Services;

class PolkadotService extends BaseService implements CryptoNetworkServiceInterface
{
    public static function symbol(): string
    {
        return 'DOT';
    }

	protected function coinType(): int
	{
		return 354;
	}
}
