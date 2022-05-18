<?php

namespace Modules\Kyc\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Kyc\Entities\Kyc;

/**
 * @property string $iban
 */
class IbanInfoRequest extends FormRequest
{

    public function rules(): array
    {
        return Kyc::$ibanInfoRule;
    }

    public function authorize(): bool
    {
        return true;
    }
}
