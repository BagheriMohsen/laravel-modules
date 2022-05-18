<?php

namespace Modules\HDWallet\Services;

interface HDWalletServiceInterface
{
    public function generateAddress(int $coinType, int|string $account=0, $change=0, $index='', string $addressType='public'): array;
}
