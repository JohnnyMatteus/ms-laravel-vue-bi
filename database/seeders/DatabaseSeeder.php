<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PassportSeeder::class,
            InvestmentTypesSeeder::class,
            ActionReturnsSeeder::class,
            PatrimonyEvolutionSeeder::class,
            AssetDistributionSeeder::class,
            SectorReturnsSeeder::class,
            RegionGrowthSeeder::class,

        ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
