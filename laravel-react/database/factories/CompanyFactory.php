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
            'Company_Name' => $this->faker->company(),
            'Company_Email' => $this->faker->unique()->companyEmail(),
            'Company_Address' => $this->faker->address(),
            'KVK' => $this->faker->numerify('########'),
            'Profession_ID' => null, // Will be set in the seeder
            'field' => $this->faker->word(),
        ];
    }
}