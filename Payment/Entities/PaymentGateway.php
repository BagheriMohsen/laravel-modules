<?php

namespace Modules\Payment\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property bool $is_active
 * @property bool $is_default
 * @property string $name
 */
class PaymentGateway extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'is_active', 'is_default'];

    public function payments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Payment::class);
    }

}
