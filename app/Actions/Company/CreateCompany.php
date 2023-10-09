<?php

namespace App\Actions\Company;

use App\Models\Company;
use Illuminate\Database\Eloquent\Model;

class CreateCompany
{
    public function handle(array $payload): Model
    {
        $company = Company::create($payload);

        return $company;
    }
}
