<?php

namespace Modules\Sms\Services;

use Ghasedak\GhasedakApi;

class GhasedakService extends BaseService implements SmsServiceInterface
{
    const VERIFY_MESSAGE_VOICE = 2;
    const VERIFY_MESSAGE_TEXT = 1;

    public function __construct()
    {
    }

    public function provider(): GhasedakApi
    {
        return new GhasedakApi(config('sms.ghasedak.api_key'));
    }

    public function send($phoneNumber, $message)
    {
        $this->provider()->SendSimple($phoneNumber, $message);
        $this->createLog($phoneNumber, $message, __METHOD__);
    }

    public function call($phoneNumber, $message, $template=null)
    {
        $this->provider()->Verify(
            $phoneNumber,
            self::VERIFY_MESSAGE_VOICE,
            $template,
        );
        $this->createLog($phoneNumber, $message, __METHOD__);
    }

    public function sendWithTemplate($template, $phoneNumber, $data = [])
    {
        $this->provider()->Verify(
            $phoneNumber,
            self::VERIFY_MESSAGE_TEXT,
            $template,
            $data
        );
        $this->createLog($phoneNumber, json_encode($data), __METHOD__);
    }
}
