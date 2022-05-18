<?php

namespace Modules\Currency\Repositories\Eloquent;

use Modules\Currency\Entities\Currency;

class CurrencyRepository extends BaseRepository implements \Modules\Currency\Repositories\CurrencyRepositoryInterface
{

	public function getFieldsSearchable(): array
	{
		return [];
	}

	public function model(): string
	{
		return Currency::class;
	}
}
