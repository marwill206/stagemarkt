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

        // Create companies
        Company::factory(15)->create()->each(function ($company) use ($professions) {
            $company->Profession_ID = $professions->random()->Profession_ID;
            $company->save();
        });

        // Create students
        Student::factory(50)->create()->each(function ($student) use ($professions, $schools) {
            $student->Profession_ID = $professions->random()->Profession_ID;
            $student->School_ID = $schools->random()->School_ID;
            $student->save();
        });
    }
}