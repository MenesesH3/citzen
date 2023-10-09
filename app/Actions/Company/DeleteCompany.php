<?php

namespace App\Actions\Company;

use Illuminate\Database\Eloquent\Model;

class DeleteCompany
{
    public function handle(Model $company): bool
    {
        $company->delete();

        return true;
    }
}
