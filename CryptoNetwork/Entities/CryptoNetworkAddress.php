<?php

namespace Modules\CryptoNetwork\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CryptoNetworkAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'currency_id',
        'network',
        'public_address',
        'private_address',
        'accuracy'
    ];

}
