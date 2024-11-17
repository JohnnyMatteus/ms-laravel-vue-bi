<?php

namespace Database\Factories;

use App\Models\InvestmentType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ActionReturn>
 */
class ActionReturnFactory extends Factory
{
    public function definition()
    {
        return [
            'investment_type_id' => InvestmentType::query()->inRandomOrder()->value('id')
                ?? InvestmentType::factory()->create()->id, // Garante que sempre há um tipo existente
            'action_code' => strtoupper($this->faker->lexify('????4')), // Gera código de ação
            'name' => $this->faker->company(),
            'description' => $this->faker->paragraph(),
            'return_percentage' => $this->faker->randomFloat(2, -10, 30),
            'date' => $this->faker->date(),
        ];
    }
}
