<?php

namespace Modules\Sms\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SmsProvider extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'is_active',
        'is_default'
    ];

}
