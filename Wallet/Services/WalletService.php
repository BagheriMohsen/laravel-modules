<?php

namespace Modules\Wallet\Services;

use Modules\Wallet\Http\Requests\WalletStoreRequest;
use Modules\Wallet\Repositories\Eloquent\WalletBlockRepositoryInterface;
use Modules\Wallet\Repositories\Eloquent\WalletRepositoryInterface;

class WalletService implements WalletServiceInterface
{
    public function __construct(public WalletRepositoryInterface $walletRepository,
                                public WalletBlockRepositoryInterface $walletBlockRepository)
    {
    }

    public function wallets(): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $user = auth()->user();

        return $this->walletRepository->walletByUserWithPaginate($user->id);
    }

    public function create(WalletStoreRequest $walletStoreRequest): \Illuminate\Database\Eloquent\Model
    {
        return $this->walletRepository->create($walletStoreRequest->all());
    }

    public function doesUserHasInventory($userId, $currencyId, $amount, $accuracy=0): bool
    {
        $wallet = $this->walletRepository->firstByUserAndCurrency($userId, $currencyId);
        $blockBalance = $this->walletBlockRepository->blockBalance($wallet->id);
        $availableBalance = bcsub($wallet->balance, $blockBalance, $accuracy);
        $result = bccomp($availableBalance, $amount, $accuracy);

        return $result == 1 || $result == 0;
    }

    public function increaseBalance($userId, $currencyId, $amount, $accuracy=0)
    {
        $wallet = $this->walletRepository->firstByUserAndCurrency($userId, $currencyId);
        $balance = bcadd($wallet->balance, $amount, $accuracy);

        return $this->walletRepository->update($wallet->id, [
            'balance' => $balance
        ]);
    }

    public function decreaseBalance($userId, $currencyId, $amount, $accuracy=0)
    {
        $wallet = $this->walletRepository->firstByUserAndCurrency($userId, $currencyId);
        $balance = bcsub($wallet->balance, $amount, $accuracy);

        return $this->walletRepository->update($wallet->id, [
           'balance' => $balance
        ]);
    }
}
