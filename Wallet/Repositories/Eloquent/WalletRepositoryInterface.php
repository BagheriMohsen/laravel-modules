<?php

namespace Modules\Wallet\Repositories\Eloquent;

interface WalletRepositoryInterface extends BaseRepositoryInterface
{
    public function walletByUserWithPaginate($userId, $perPage = 15): \Illuminate\Contracts\Pagination\LengthAwarePaginator;

    public function firstByUserAndCurrency($userId, $currencyId): object|null;
}
