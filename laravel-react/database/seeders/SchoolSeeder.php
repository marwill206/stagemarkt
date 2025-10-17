<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\School;

class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Static list of schools
        $schools = [
            ['School_Name' => 'ROC Utrecht'],
            ['School_Name' => 'ROC Amsterdam'],
            ['School_Name' => 'ROC Rotterdam'],
            ['School_Name' => 'Hogeschool Utrecht'],
            ['School_Name' => 'Universiteit Utrecht'],
            ['School_Name' => 'TU Delft'],
            ['School_Name' => 'Grafisch Lyceum Utrecht'],
            ['School_Name' => 'Media College Amsterdam'],
        ];

        // Insert schools into the database
        School::insert($schools);
    }
}