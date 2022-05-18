<?php

namespace Modules\Wallet\Repositories\Eloquent;

use Modules\Wallet\Entities\Wallet;

class WalletRepository extends BaseRepository implements WalletRepositoryInterface
{

    public function getFieldsSearchable(): array
    {
        return [];
    }

    public function model(): string
    {
        return Wallet::class;
    }

    public function walletByUserWithPaginate($userId, $perPage = 15): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return $this->query()
            ->where('user_id', $userId)
            ->paginate($perPage);
    }

    public function firstByUserAndCurrency($userId, $currencyId): object|null
    {
        return $this->query()
            ->where('user_id', $userId)
            ->where('currency_id', $currencyId)
            ->firstOrFail();
    }
}
