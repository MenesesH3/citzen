<?php

namespace App\Actions\Company;

use Illuminate\Database\Eloquent\Model;

class UpdateCompany
{
    public function handle(Model $company, array $payload): bool
    {
        $company->update($payload);

        return true;
    }
}
