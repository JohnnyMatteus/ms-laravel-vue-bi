<?php

namespace Database\Seeders;

use App\Models\SectorReturn;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SectorReturnsSeeder extends Seeder
{
    public function run()
    {
        SectorReturn::factory()->count(500)->create();
    }
}
