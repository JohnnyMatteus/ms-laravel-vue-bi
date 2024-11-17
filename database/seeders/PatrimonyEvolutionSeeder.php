<?php

namespace Database\Seeders;

use App\Models\PatrimonyEvolution;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PatrimonyEvolutionSeeder extends Seeder
{
    public function run()
    {
        PatrimonyEvolution::factory()->count(500)->create();
    }
}
