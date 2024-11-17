<?php

namespace Database\Factories;

use App\Models\InvestmentType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AssetDistribution>
 */
class AssetDistributionFactory extends Factory
{
    public function definition()
    {
        return [
            'investment_type_id' => InvestmentType::query()->inRandomOrder()->value('id')
                ?? InvestmentType::factory()->create()->id,
            'category' => $this->faker->randomElement(['Ações', 'FIIs', 'Renda Fixa']),
            'percentage' => $this->faker->randomFloat(2, 1, 100),
            'details' => $this->faker->paragraph(),
        ];
    }
}
