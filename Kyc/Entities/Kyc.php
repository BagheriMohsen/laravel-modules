<?php

namespace Modules\Kyc\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\User\Entities\User;

class Kyc extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'sent_data', 'receive_data'];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static array $cardInfoRule = [
        'iban' => ['required']
    ];

    public static array $ibanInfoRule = [
        'card_number' => ['required']
    ];

    public static array $getIbanFromCardRule = [
        'card_number' => ['required']
    ];

    public static array $matchMobileNumberAndNationalCodeRule = [
        'cellphone' => ['required'],
        'national_code' => ['required']
    ];

    public static array $nameSimilarityRule = [
        'national_code' => ['required'],
        'birthday' => ['required'],
        'full_name' => ['required'],
        'first_name' => ['required'],
        'last_name' => ['required'],
        'father_name' => ['required']
    ];

    public static array $getAddressFromPostalCodeRule = [
        'postal_code' => ['required']
    ];

}
