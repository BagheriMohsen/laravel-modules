<?php

namespace Modules\Wallet\Services;

interface WalletServiceInterface
{
    public function doesUserHasInventory($userId, $currencyId, $amount, $accuracy=0): bool;

    public function increaseBalance($userId, $currencyId, $amount, $accuracy=0);

    public function decreaseBalance($userId, $currencyId, $amount, $accuracy=0);
}
