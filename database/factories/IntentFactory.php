<?php

namespace Database\Factories;

use App\Models\Intent;
use Illuminate\Database\Eloquent\Factories\Factory;

class IntentFactory extends Factory
{
    protected $model = Intent::class;

    public function definition(): array
    {
        $label = $this->faker->words(2, true); // ej: "agendar cita"
        $key = str_replace(' ', '_', strtolower($label)) . ':iniciar';

        return [
            'intent' => ucfirst($label),
            'key' => $key,
            'description' => $this->faker->sentence,
        ];
    }
}
