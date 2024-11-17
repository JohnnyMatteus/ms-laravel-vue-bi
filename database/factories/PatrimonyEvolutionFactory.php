<?php

namespace Database\Factories;

use App\Models\InvestmentType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PatrimonyEvolution>
 */
class PatrimonyEvolutionFactory extends Factory
{
    public function definition()
    {
        return [
            'investment_type_id' => InvestmentType::query()->inRandomOrder()->value('id')
                ?? InvestmentType::factory()->create()->id,
            'month' => $this->faker->monthName, // Nome do mês
            'year' => $this->faker->numberBetween(2000, 2024), // Ano aleatório
            'value' => $this->faker->randomFloat(2, 1000, 50000), // Valor da evolução
            'description' => $this->faker->sentence(), // Descrição
        ];
    }
}
