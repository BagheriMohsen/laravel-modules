<?php

namespace Modules\Wallet\Repositories\Eloquent;

use Modules\Wallet\Entities\WalletBlock;

class WalletBlockRepository extends BaseRepository implements WalletBlockRepositoryInterface
{

    public function getFieldsSearchable(): array
    {
        return [];
    }

    public function model(): string
    {
        return WalletBlock::class;
    }

    public function blockBalance($walletId)
    {
        return $this->query()
            ->where('wallet_id', $walletId)
            ->where('deleted_at', null)
            ->where('expire_at', '>', now()->timestamp)
            ->sum('amount');
    }
}
