<?php

namespace Modules\Sms\Channels;

use Modules\Sms\Services\SmsServiceInterface;
use Illuminate\Notifications\Notification;

class CallChannel implements NotificationChannelInterface
{
    public function send($notifiable, Notification $notification) {
        $callOutput = $notification->toCall();
        if(config('sms.call.status')) {
            $smsService = app()->make(SmsServiceInterface::class);
            $smsService->call($notifiable->cellphone, $callOutput->message);
        }
    }
}
