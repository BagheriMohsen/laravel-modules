<?php

namespace Modules\Payment\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $amount
 * @property string $card_number
 * @property string $description
 */
class PaymentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
