<?php

namespace Modules\Kyc\Services;

class BaseService
{
    public function convertFullNameToValidFormat($name): array|string
    {
        return str_replace('ي', 'ی', $name);
    }
}
