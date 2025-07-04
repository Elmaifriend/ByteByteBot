<?php

namespace Database\Factories;

use App\Models\Conversation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Conversation>
 */
class ConversationFactory extends Factory
{
    protected $model = Conversation::class;

    public function definition(): array
    {
        return [
            'phone' => $this->faker->e164PhoneNumber,
            'status' => $this->faker->randomElement(['open', 'closed', 'pending']),
            'data' => [
                'last_seen' => now()->toDateTimeString(),
                'notes' => $this->faker->sentence,
            ],
        ];
    }
}
