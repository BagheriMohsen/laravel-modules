<?php

namespace Modules\Sms\Channels;

use Illuminate\Notifications\Notification;

interface NotificationChannelInterface
{
    public function send($notifiable, Notification $notification);
}
