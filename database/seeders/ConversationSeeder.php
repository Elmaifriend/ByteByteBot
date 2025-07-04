<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Conversation;
use App\Models\Message;

class ConversationSeeder extends Seeder
{
    public function run(): void
    {
        // Crear 100 conversaciones
        Conversation::factory()->count(100)->create()->each(function ($conversation) {
            // Crear entre 1 y 5 mensajes por conversación
            Message::factory()
                ->count(rand(1, 5))
                ->create([
                    'conversation_id' => $conversation->id,
                ]);
        });
    }
}
