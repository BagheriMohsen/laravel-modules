<?php

namespace Modules\CryptoNetwork\Services;

class ByteTradeService extends BaseService implements CryptoNetworkServiceInterface
{
    public static function symbol(): string
    {
        return 'BTT';
    }

	protected function coinType(): int
	{
		return 34952;
	}
}
