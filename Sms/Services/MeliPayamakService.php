<?php

namespace Modules\Sms\Services;

use Illuminate\Support\Facades\Log;
use Melipayamak\MelipayamakApi;

class MeliPayamakService extends BaseService implements SmsServiceInterface
{

    public function __construct()
    {
    }

    public function provider(): MelipayamakApi
    {
        return new MelipayamakApi(config('sms.meli_payamak.username'), config('sms.meli_payamak.password'));
    }

    public function send($phoneNumber, $message)
    {
        try
        {
            $sms = $this->provider()->sms();
            $sms->send($phoneNumber, config('sms.meli_payamak.sender'), $message);
            $this->createLog($phoneNumber, $message, __METHOD__);
        } catch (\Exception $e) {
            Log::error($e);
        }

    }

    public function call($phoneNumber, $message)
    {
    }

    public function sendWithTemplate($template, $phoneNumber, array $data = [])
    {
    }
}
