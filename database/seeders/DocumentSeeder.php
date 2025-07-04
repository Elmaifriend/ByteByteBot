<?php

namespace Database\Seeders;

use App\Models\Conversation; // <-- ¡CAMBIO AQUÍ!
use App\Models\Document;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Asegúrate de que hay conversaciones para adjuntar documentos
        if (Conversation::count() === 0) {
            // Si no hay conversaciones, crea algunas primero
            // Asumiendo que tu factory de Conversation crea datos válidos
            Conversation::factory()->count(10)->create();
        }

        // Para cada conversación existente, adjunta entre 1 y 3 documentos
        Conversation::all()->each(function (Conversation $conversation) { // <-- ¡CAMBIO AQUÍ!
            Document::factory()->count(rand(1, 3))->create([
                'conversation_id' => $conversation->id, // <-- ¡CAMBIO AQUÍ!
            ]);
        });

        // Opcional: crea algunos documentos sin asociar a ninguna conversación si `conversation_id` es nullable
        Document::factory()->count(5)->create([
            'conversation_id' => null, // <-- ¡CAMBIO AQUÍ!
        ]);
    }
}
