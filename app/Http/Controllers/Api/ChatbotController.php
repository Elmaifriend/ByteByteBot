<?php
namespace App\Http\Controllers\Api;

use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChatbotController extends Controller
{
    /**
     * 🔹 POST /api/message
     * Guarda mensaje entrante o saliente
     */
    public function storeMessage(Request $request)
    {
        $validated = $request->validate([
            'phone' => 'required|string',
            'name' => 'nullable|string',
            'message' => 'required|string',
            'role' => 'required|in:user,assistant',
        ]);

        // Buscar o crear la conversación por teléfono
        $conversation = Conversation::firstOrCreate(
            ['phone' => $validated['phone']],
            ['status' => 'esperando', 'data' => []]
        );

        // Si llega el nombre y es diferente al actual, actualizarlo
        if (!empty($validated['name']) && $validated['name'] !== $conversation->name) {
            $conversation->name = $validated['name'];
            $conversation->save();
        }

        // Crear el mensaje asociado
        $message = $conversation->messages()->create([
            'role' => $validated['role'],
            'content' => $validated['message'],
        ]);

        return response()->json([
            'success' => true,
            'conversation_id' => $conversation->id,
            'message_id' => $message->id,
        ]);
    }

    /**
     * 🔹 GET /api/messages/{phone}?limit=20
     * Obtener historial de mensajes
     */
    public function getMessages(Request $request, string $phone)
    {
        $limit = $request->get('limit', 20);

        $conversation = Conversation::where('phone', $phone)->first();

        if (!$conversation) {
            return response()->json(['error' => 'Conversation not found'], 404);
        }

        $messages = $conversation->messages()
            ->orderBy('created_at', 'desc')
            ->take($limit)
            ->get()
            ->reverse()
            ->values();

        return response()->json($messages);
    }

    /**
     * 🔹 POST /api/conversations/{phone}/update
     * Actualizar status y/o data
     */
    public function updateConversation(Request $request, string $phone)
    {
        $validated = $request->validate([
            'next_status' => 'nullable|string',
            'update' => 'nullable|array',
        ]);

        $conversation = Conversation::where('phone', $phone)->first();

        if (!$conversation) {
            return response()->json(['error' => 'Conversation not found'], 404);
        }

        if (isset($validated['update'])) {
            $merged = array_merge($conversation->data ?? [], $validated['update']);
            $conversation->data = $merged;
        }

        if (isset($validated['next_status'])) {
            $conversation->status = $validated['next_status'];
        }

        $conversation->save();

        return response()->json([
            'success' => true,
            'status' => $conversation->status,
            'data' => $conversation->data,
        ]);
    }

    /**
     * 🔹 GET /api/conversations/{phone}/status
     * Obtener status actual y data
     */
    public function getStatus(string $phone)
    {
        $conversation = Conversation::where('phone', $phone)->first();

        if (!$conversation) {
            return response()->json(['error' => 'Conversation not found'], 404);
        }

        return response()->json([
            'status' => $conversation->status,
            'data' => $conversation->data,
        ]);
    }
}
