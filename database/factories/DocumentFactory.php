<?php

namespace Database\Factories;

use App\Models\Conversation; // <-- ¡CAMBIO AQUÍ! Importar Conversation
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Document>
 */
class DocumentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $fileTypes = [
            'application/pdf' => 'pdf',
            'application/msword' => 'doc',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
            'application/vnd.ms-excel' => 'xls',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'xlsx',
            'text/plain' => 'txt',
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
        ];

        $mimeType = array_rand($fileTypes);
        $extension = $fileTypes[$mimeType];
        $fileName = $this->faker->word() . '_' . $this->faker->unique()->randomNumber(4) . '.' . $extension;

        return [
            'conversation_id' => Conversation::factory(), // <-- ¡CAMBIO AQUÍ! Asocia con una conversación
            'file_name' => $fileName,
            'file_path' => 'documents/' . $this->faker->uuid() . '/' . $fileName,
            'file_size' => $this->faker->numberBetween(1024, 5000000),
            'mime_type' => $mimeType,
            'description' => $this->faker->sentence(),
        ];
    }
}
