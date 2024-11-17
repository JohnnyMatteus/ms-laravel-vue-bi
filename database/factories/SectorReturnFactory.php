<?php

namespace Database\Factories;

use App\Models\InvestmentType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SectorReturn>
 */
class SectorReturnFactory extends Factory
{
    public function definition()
    {
        return [
            'investment_type_id' => InvestmentType::query()->inRandomOrder()->value('id')
                ?? InvestmentType::factory()->create()->id,
            'sector' => $this->faker->randomElement(['Tecnologia', 'Saúde', 'Financeiro', 'Indústria', 'Energia']),
            'return_percentage' => $this->faker->randomFloat(2, -10, 30),
        ];
    }
}
