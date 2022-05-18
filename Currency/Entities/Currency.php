<?php

namespace Modules\Currency\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Currency extends Model
{
    use HasFactory;

    const TYPE_CRYPTO = 'CRYPTO';
    const TYPE_FIAT = 'FIAT';

    protected $fillable = [
        'name',
        'logo',
        'type',
        'code',
        'is_active',
        'description',
        'accuracy'
    ];

}
