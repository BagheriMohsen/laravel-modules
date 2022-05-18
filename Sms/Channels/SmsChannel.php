<?php

namespace Modules\Sms\Channels;


use Modules\Sms\Services\SmsServiceInterface;
use Illuminate\Notifications\Notification;

class SmsChannel implements NotificationChannelInterface
{

    public function send($notifiable, Notification $notification)
    {
        $smsOutput = $notification->toSms($notifiable);

        $smsService = resolve(SmsServiceInterface::class);

        if(! $smsOutput->templateName) {
            $smsService->send($smsOutput->phone, $smsOutput->message);
        } else {
            $smsService->sendWithTemplate($smsOutput->templateName, $smsOutput->phone, $smsOutput->data);
        }
    }
}
