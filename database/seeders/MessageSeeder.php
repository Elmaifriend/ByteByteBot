<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Message;
use App\Models\Conversation;

class MessageSeeder extends Seeder
{
    public function run(): void
    {
        $conversations = Conversation::all();

        foreach ($conversations as $conversation) {
            // Generar entre 4 y 8 mensajes por conversación
            $count = rand(10, 50);

            // Vamos a ir alternando los roles: user -> assistant -> user -> assistant ...
            $roles = ['user', 'assistant'];

            for ($i = 0; $i < $count; $i++) {
                Message::create([
                    'conversation_id' => $conversation->id,
                    'role' => $roles[$i % 2], // alterna entre 'user' y 'assistant'
                    'content' => $this->generateContent($roles[$i % 2]),
                ]);
            }
        }
    }

    private function generateContent(string $role): string
    {
        $userMessages = [
            'Hola, ¿me puedes ayudar con un problema?',
            '¿Cuál es el estado de mi pedido?',
            'Necesito información sobre sus productos.',
            '¿Cómo cambio mi contraseña?',
            'Gracias por la ayuda.',
        ];

        $assistantMessages = [
            'Claro, dime cuál es el problema.',
            'Tu pedido está en camino y llegará mañana.',
            'Tenemos una variedad de productos, ¿qué te interesa?',
            'Puedes cambiar tu contraseña desde tu perfil en configuración.',
            'De nada, ¡estoy aquí para ayudarte!',
        ];

        if ($role === 'user') {
            return $userMessages[array_rand($userMessages)];
        } else {
            return $assistantMessages[array_rand($assistantMessages)];
        }
    }
}
