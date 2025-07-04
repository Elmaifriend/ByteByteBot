<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Importar BelongsTo
use App\Models\Conversation; // <-- ¡IMPORTANTE! Importar el modelo Conversation

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'conversation_id', // <-- ¡CAMBIO AQUÍ!
        'file_name',
        'file_path',
        'file_size',
        'mime_type',
        'description',
    ];

    /**
     * Get the conversation that owns the document.
     */
    public function conversation(): BelongsTo // <-- ¡CAMBIO AQUÍ!
    {
        return $this->belongsTo(Conversation::class); // <-- ¡CAMBIO AQUÍ!
    }
}
