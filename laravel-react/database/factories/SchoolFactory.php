<?php

namespace Database\Factories;

use App\Models\School;
use Illuminate\Database\Eloquent\Factories\Factory;

class SchoolFactory extends Factory
{
    protected $model = School::class;

    public function definition(): array
    {
        $schoolNames = [
            'ROC Utrecht',
            'ROC Amsterdam',
            'ROC Rotterdam',
            'Hogeschool Utrecht',
            'Universiteit Utrecht',
            'TU Delft',
            'Grafisch Lyceum Utrecht',
            'Media College Amsterdam',
        ];

        return [
            'School_Name' => $this->faker->randomElement($schoolNames),
        ];
    }
}