<?php

namespace Database\Seeders;

use App\Models\RegionGrowth;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RegionGrowthSeeder extends Seeder
{
    public function run()
    {
        RegionGrowth::factory()->count(500)->create();
    }
}
