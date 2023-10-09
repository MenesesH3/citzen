<?php

namespace App\Http\Requests\Company;

use App\Rules\CheckCnaeRule;
use App\Rules\NumberCharsRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BaseCompanyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return false;
    }

    public function rules(): array
    {
        return [
            'company_name' => ['required', 'string'],
            'trading_name' => ['required', 'string'],
            'cnpj' => ['required', 'string', Rule::unique('companies')->ignore($this->id), new NumberCharsRule(), new CheckCnaeRule()],
            'company_email' => ['required', 'email', Rule::unique('companies')->ignore($this->id)],
            'person_responsible' => ['required', 'string'],
            'foundation_date' => ['required', 'date'],
        ];
    }
}
