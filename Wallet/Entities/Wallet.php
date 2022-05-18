<?php

namespace Modules\Wallet\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wallet extends Model
{
    use HasFactory,
        SoftDeletes;

    protected $fillable = [
        'user_id',
        'currency_id',
        'balance',
        'is_active',
        'props'
    ];
}
