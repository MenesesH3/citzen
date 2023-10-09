<?php

namespace App\Http\Requests\Company;

class UpdateCompanyRequest extends BaseCompanyRequest
{
    public function authorize(): bool
    {
        return true;
    }
}
