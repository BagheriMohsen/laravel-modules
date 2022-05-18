<?php

namespace Modules\Wallet\Services;

use Modules\Wallet\Repositories\Eloquent\WalletBlockRepositoryInterface;

class WalletBlockService implements WalletBlockServiceInterface
{
    public function __construct(public WalletBlockRepositoryInterface $walletBlockRepository)
    {
    }

    public function create($walletId, $amount, $expireAt=null): \Illuminate\Database\Eloquent\Model
    {
        return $this->walletBlockRepository->create([
            'wallet_id' => $walletId,
            'amount' => $amount,
            'expireAt' => $expireAt
        ]);
    }
}
