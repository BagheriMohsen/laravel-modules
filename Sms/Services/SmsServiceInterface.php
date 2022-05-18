<?php

namespace Modules\Sms\Services;

interface SmsServiceInterface
{
    public function send($phoneNumber, $message);

    public function call($phoneNumber, $message);

    public function sendWithTemplate($template, $phoneNumber, array $data = []);
}
