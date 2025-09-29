<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Student;
use App\Models\Profession;
use App\Models\School;

class StudentFactory extends Factory
{
    protected $model = Student::class;
    public function definition(): array
    {
        return [
            'Student_Name' => $this->faker->name(),
            'Student_Email' => $this->faker->unique()->safeEmail(),
            'Portfolio_Link' => $this->faker->optional()->url(),
            'About_Text' => $this->faker->optional()->paragraph(),
            'Address' => $this->faker->address(),
            'Age' => $this->faker->numberBetween(16, 25),
            'Gender' => $this->faker->randomElement(['Male', 'Female', 'Other']),
            'Foto' => $this->faker->optional()->imageUrl(200, 200, 'people'),
            'Profession_ID' => null, // Will be set in the seeder
            'School_ID' => null, // Will be set in the seeder
        ];
    }
}
