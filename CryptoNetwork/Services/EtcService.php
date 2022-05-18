<?php

namespace Modules\CryptoNetwork\Services;

class EtcService extends BaseService implements CryptoNetworkServiceInterface
{
    public static function symbol(): string
    {
        return 'ETC';
    }

	protected function coinType(): int
	{
		return 61;
	}
}
