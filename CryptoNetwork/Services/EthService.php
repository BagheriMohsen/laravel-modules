<?php

namespace Modules\CryptoNetwork\Services;

class EthService extends BaseService implements CryptoNetworkServiceInterface
{
    public static function symbol(): string
    {
        return 'ETH';
    }

	protected function coinType(): int
	{
		return 60;
	}
}
