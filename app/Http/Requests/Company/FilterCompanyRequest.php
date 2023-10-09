<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FilterCompanyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'company_name' => ['nullable'],
            'trading_name' => ['nullable'],
            'cnpj' => ['nullable'],
            'company_email' => ['nullable'],
            'person_responsible' => ['nullable'],
            'foundation_date' => ['nullable'],
        ];
    }
}
