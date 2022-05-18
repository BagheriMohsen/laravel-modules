<?php

namespace Modules\CryptoNetwork\Services;

class TronService extends BaseService implements CryptoNetworkServiceInterface
{
    public static function symbol(): string
    {
        return 'TRX';
    }

	protected function coinType(): int
	{
		return 195;
	}
}
