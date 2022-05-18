<?php

namespace Modules\CryptoNetwork\Repositories\Eloquent;

use Modules\CryptoNetwork\Entities\CryptoNetworkAddress;
use Modules\CryptoNetwork\Repositories\CryptoNetworkAddressRepositoryInterface;

class CryptoNetworkAddressRepository extends BaseRepository implements CryptoNetworkAddressRepositoryInterface
{

	public function getFieldsSearchable(): array
	{
		return [];
	}

	public function model(): string
	{
		return CryptoNetworkAddress::class;
	}
}
