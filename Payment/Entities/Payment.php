<?php

namespace Modules\Payment\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\User\Entities\User;

/**
 * @property string $amount
 * @property string $mobile
 * @property string $description
 * @property string $card_number
 * @property mixed $user_note
 * @property User $user
 * @property string $tracking_code
 * @property mixed $id
 */
class Payment extends Model
{
    use HasFactory;

    const STATUS_PENDING = 'PENDING';
    const STATUS_FAILED = 'FAILED';
    const STATUS_SUCCESS = 'SUCCESS';

    protected $fillable = [
        'user_id',
        'payment_gateway_id',
        'amount',
        'tracking_code',
        'card_number',
        'sent_date',
        'receive_data',
        'props',
        'admin_note',
        'user_note',
        'status'
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public static function cacheKeyPaymentData($trackingCode): string
    {
        return 'payment_data:tracking_code:'.$trackingCode;
    }

    public function gateway(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(PaymentGateway::class);
    }

}
