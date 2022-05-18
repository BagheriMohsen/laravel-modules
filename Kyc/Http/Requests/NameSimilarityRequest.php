<?php

namespace Modules\Kyc\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Kyc\Entities\Kyc;

/**
 * @property string $national_code
 * @property string $birth_day
 * @property string $full_name
 * @property string $first_name
 * @property string $last_name
 * @property string $father_name
 */
class NameSimilarityRequest extends FormRequest
{

    public function rules(): array
    {
        return Kyc::$nameSimilarityRule;
    }

    public function authorize(): bool
    {
        return true;
    }
}
