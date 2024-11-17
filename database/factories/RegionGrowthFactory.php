<?php

namespace Database\Factories;

use App\Models\InvestmentType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RegionGrowth>
 */
class RegionGrowthFactory extends Factory
{
    public function definition()
    {
        return [
            'investment_type_id' => InvestmentType::query()->inRandomOrder()->value('id')
                ?? InvestmentType::factory()->create()->id,
            'region' => $this->faker->randomElement(['Norte', 'Nordeste', 'Sudeste', 'Sul', 'Centro-Oeste']),
            'growth_rate' => $this->faker->randomFloat(2, -5, 20), // Alterado para valores realistas
        ];
    }
}
