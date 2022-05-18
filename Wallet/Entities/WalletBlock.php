<?php

namespace Modules\Wallet\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class WalletBlock extends Model
{
    use HasFactory,
        SoftDeletes;

    protected $fillable = [
        'wallet_id',
        'initial_amount',
        'amount',
        'block_reason',
        'unblock_reason',
        'props',
        'expired_at'
    ];

    public array $cast = [
        'expire_at' => 'datetime'
    ];
}
