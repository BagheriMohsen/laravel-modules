<?php

namespace Modules\CryptoNetwork\Services;

interface CryptoNetworkServiceInterface
{
    public function generateAddress(int $account=0, int $change=0, string $addressIndex='', $addressType='private'): array;
}
