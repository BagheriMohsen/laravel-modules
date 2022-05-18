<?php

namespace Modules\Sms\Channels\Output;

class SmsOutput
{
    public function __construct(public string $phone,
                                public string $message = '',
                                public string $templateName='',
                                public array $data = [])
    {
    }
}
