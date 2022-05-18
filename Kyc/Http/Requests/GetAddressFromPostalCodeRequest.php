<?php

namespace Modules\Kyc\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Kyc\Entities\Kyc;

/**
 * @property string $postal_code
 */
class GetAddressFromPostalCodeRequest extends FormRequest
{

    public function rules(): array
    {
        return Kyc::$getAddressFromPostalCodeRule;
    }

    public function authorize(): bool
    {
        return true;
    }
}
