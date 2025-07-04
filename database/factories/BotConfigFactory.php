<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\BotConfig;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BotConfig>
 */
class BotConfigFactory extends Factory
{
    protected $model = BotConfig::class;

    public function definition(): array
    {
        return [
            'rules' => $this->faker->paragraphs(3, true), // genera 3 párrafos en texto
        ];
    }
}
