<?php

namespace Modules\Sms\Services;

use Ghasedak\GhasedakApi;
use Ghasedak\Laravel\GhasedakFacade;

class GhasedakService extends BaseService implements SmsServiceInterface
{
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
            GhasedakFacade::VERIFY_MESSAGE_VOICE,
            $template,
        );
        $this->createLog($phoneNumber, $message, __METHOD__);
    }

    public function sendWithTemplate($template, $phoneNumber, $data = [])
    {
        $this->provider()->Verify(
            $phoneNumber,
            GhasedakFacade::VERIFY_MESSAGE_TEXT,
            $template,
            $data
        );
        $this->createLog($phoneNumber, json_encode($data), __METHOD__);
    }
}
