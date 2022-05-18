<?php

namespace Modules\Auth\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;
use Modules\User\Entities\User;

class RegisterRequest extends FormRequest
{

    public function rules(): array
    {
        return User::$registerRule;
    }

    public function authorize(): bool
    {
        return true;
    }
}
