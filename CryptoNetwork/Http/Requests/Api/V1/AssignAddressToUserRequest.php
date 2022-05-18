<?php

namespace Modules\CryptoNetwork\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class AssignAddressToUserRequest extends FormRequest
{

    public function rules()
    {
        return [
            //
        ];
    }

    public function authorize()
    {
        return true;
    }
}
