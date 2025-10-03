<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\Company;
use App\Models\Profession;
use App\Models\School;
use Illuminate\Database\Seeder;

class StudentCompanySeeder extends Seeder
{
    public function run(): void
    {
        // Get all professions and schools
        $professions = Profession::all();
        $schools = School::all();

        if ($professions->isEmpty() || $schools->isEmpty()) {
            $this->command->error('Professions or schools not found. Run other seeders first.');
            return;
        }

        // Create companies with profession_id assigned during creation
        for ($i = 0; $i < 15; $i++) {
            Company::factory()->create([
                'Profession_ID' => $professions->random()->Profession_ID
            ]);
        }

        // Create students with profession_id and school_id assigned during creation
        for ($i = 0; $i < 50; $i++) {
            Student::factory()->create([
                'Profession_ID' => $professions->random()->Profession_ID,
                'School_ID' => $schools->random()->School_ID
            ]);
        }

        $this->command->info('Created ' . Company::count() . ' companies');
        $this->command->info('Created ' . Student::count() . ' students');
    }
}