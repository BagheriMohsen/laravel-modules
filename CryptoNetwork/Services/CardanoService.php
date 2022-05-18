<?php

namespace Modules\CryptoNetwork\Services;

class CardanoService extends BaseService implements CryptoNetworkServiceInterface
{
    public static function symbol(): string
    {
        return 'ADA';
    }

	protected function coinType(): int
	{
		return 1815;
	}
}
