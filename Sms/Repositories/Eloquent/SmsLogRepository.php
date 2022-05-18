<?php

namespace Modules\Sms\Repositories\Eloquent;

use Modules\Sms\Entities\SmsLog;

class SmsLogRepository extends BaseRepository implements \Modules\Sms\Repositories\SmsLogRepositoryInterface
{

	public function getFieldsSearchable(): array
	{
		return [];
	}

	public function model(): string
	{
		return SmsLog::class;
	}
}
