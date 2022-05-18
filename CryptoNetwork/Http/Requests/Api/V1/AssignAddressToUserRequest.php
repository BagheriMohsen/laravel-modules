<?php

namespace Modules\CryptoNetwork\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;


/**
 * @property mixed $network
 */
class AssignAddressToUserRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'currency_name' => ['required'],
            'network' => ['required']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
