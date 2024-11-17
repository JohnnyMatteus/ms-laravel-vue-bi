<?php

namespace Database\Seeders;

use App\Models\AssetDistribution;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AssetDistributionSeeder extends Seeder
{
    public function run()
    {
        AssetDistribution::factory()->count(500)->create();
    }
}
