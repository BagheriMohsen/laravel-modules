<?php

namespace Modules\Sms\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\User\Entities\User;

class SmsLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'cellphone',
        'driver',
        'message',
        'method'
    ];

}
