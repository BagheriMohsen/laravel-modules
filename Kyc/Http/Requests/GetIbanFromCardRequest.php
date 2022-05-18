<?php

namespace Modules\Kyc\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Kyc\Entities\Kyc;

/**
 * @property string $card_number
 */
class GetIbanFromCardRequest extends FormRequest
{

    public function rules(): array
    {
        return Kyc::$getIbanFromCardRule;
    }

    public function authorize(): bool
    {
        return true;
    }
}
