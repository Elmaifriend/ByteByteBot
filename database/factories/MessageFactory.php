<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use app\Models\Message;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Message>
 */
class MessageFactory extends Factory
{
    protected $model = Message::class;

    public function definition(): array
    {
        return [
            'role' => $this->faker->randomElement(['user', 'assistant']),
            'content' => $this->faker->paragraph,
            // conversation_id se asigna en el seeder
        ];
    }
}
