<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\School;

class SchoolSeeder extends Seeder
{
    public function run(): void
    {
        // Create specific schools
        $schools = [
            'ROC Utrecht',
            'ROC Amsterdam', 
            'ROC Rotterdam',
            'Hogeschool Utrecht',
            'Universiteit Utrecht',
            'TU Delft',
            'Grafisch Lyceum Utrecht',
            'Media College Amsterdam',
        ];

        foreach ($schools as $schoolName) {
            School::create(['School_Name' => $schoolName]);
        }
    }
}