<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conversation_id')
                  ->nullable()
                  ->constrained('conversations')
                  ->onDelete('cascade');

            $table->string('file_name'); // Nombre original del archivo
            $table->string('file_path'); // Ruta donde se almacena el archivo

            // ¡CAMBIOS AQUÍ! HACEMOS ESTOS CAMPOS NULLABLES
            $table->integer('file_size')->unsigned()->nullable(); // <-- Añadido ->nullable()
            $table->string('mime_type')->nullable(); // <-- Añadido ->nullable()

            $table->text('description')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
