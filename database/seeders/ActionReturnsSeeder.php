<?php

namespace Database\Seeders;

use App\Models\ActionReturn;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ActionReturnsSeeder extends Seeder
{
    public function run()
    {
        ActionReturn::factory()->count(1000)->create();
    }
}
