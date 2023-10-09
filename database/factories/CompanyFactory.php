<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    protected $model = Company::class;

    public function definition(): array
    {
        return [
            'company_name' => $this->faker->company,
            'trading_name' => $this->faker->companySuffix,
            'cnpj' => (string) $this->faker->numerify('##############'),
            'company_email' => $this->faker->unique()->safeEmail,
            'person_responsible' => $this->faker->name,
            'foundation_date' => $this->faker->date(),
        ];
    }
}
