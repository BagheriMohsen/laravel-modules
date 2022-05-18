<?php

namespace Modules\Kyc\Repositories\Eloquent;

use Modules\Kyc\Entities\Kyc;
use Modules\Kyc\Repositories\KycRepositoryInterface;

class KycRepository extends BaseRepository implements KycRepositoryInterface
{

	public function getFieldsSearchable(): array
	{
		return [];
	}

	public function model(): string
	{
		return Kyc::class;
	}
}
