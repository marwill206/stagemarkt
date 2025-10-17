<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Profession;

class ProfessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Static list of professions
        $professions = [
            ['Profession_Name' => 'Software Developer'],
            ['Profession_Name' => 'Graphic Designer'],
            ['Profession_Name' => 'Data Analyst'],
            ['Profession_Name' => 'Network Engineer'],
            ['Profession_Name' => 'Media Manager'],
        ];

        // Insert professions into the database
        Profession::insert($professions);
    }
}