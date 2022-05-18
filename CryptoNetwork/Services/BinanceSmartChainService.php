<?php

namespace Modules\CryptoNetwork\Services;

class BinanceSmartChainService extends BaseService implements CryptoNetworkServiceInterface
{

	public static function symbol(): string
	{
		return 'BSC';
	}

	/**
	 * @inheritDoc
	 */
	protected function coinType(): int
	{
		return 9006;
	}
}
