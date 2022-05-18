<?php

namespace Modules\Kyc\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Kyc\Entities\Kyc;

/**
 * @property string $cellphone
 * @property string $national_code
 */
class MatchCellphoneAndNationalCodeRequest extends FormRequest
{

    public function rules(): array
    {
        return Kyc::$matchMobileNumberAndNationalCodeRule;
    }

    public function authorize(): bool
    {
        return true;
    }
}
