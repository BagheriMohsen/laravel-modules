<?php

namespace Modules\Wallet\Repositories\Eloquent;

interface WalletBlockRepositoryInterface extends BaseRepositoryInterface
{
    public function blockBalance($walletId);
}
