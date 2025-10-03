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
        // Generate 10 dummy professions
        Profession::factory()->count(10)->create();
    }
}