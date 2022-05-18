<?php

namespace Modules\Sms\Channels\Output;

class CallOutput
{
    public function __construct(public string $message)
    {
    }
}
