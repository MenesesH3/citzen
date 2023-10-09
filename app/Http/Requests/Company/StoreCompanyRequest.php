<?php

namespace App\Http\Requests\Company;

class StoreCompanyRequest extends BaseCompanyRequest
{
    public function authorize(): bool
    {
        return true;
    }
}
