<?php

namespace Modules\Sms\Services;


use Modules\Sms\Repositories\SmsLogRepositoryInterface;

class BaseService
{

    public function createLog($cellphone, $message, $method): void
    {
        if(config('sms.have_log')) {
            $smsLogRepository = resolve(SmsLogRepositoryInterface::class);
            $smsLogRepository->create([
                'cellphone' => $cellphone,
                'driver' => config('sms.driver'),
                'message' => $message,
                'method' => $method
            ]);
        }
    }
}
