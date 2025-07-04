<?php

namespace Database\Factories;

use App\Models\Message;
use Illuminate\Database\Eloquent\Factories\Factory;

class MessageFactory extends Factory
{
    protected $model = Message::class;

    public function definition(): array
    {
        $createdAt = $this->faker->dateTimeBetween('-1 month', 'now');

        return [
            'conversation_id' => null, // Se asignará en el seeder
            'role' => $this->faker->randomElement(['user', 'assistant']),
            'content' => $this->faker->paragraph,
            'created_at' => $createdAt,
            'updated_at' => $this->faker->dateTimeBetween($createdAt, 'now'),
        ];
    }
}
