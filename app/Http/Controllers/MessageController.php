<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function store(Request $request, $chatId)
    {
        $user = auth()->user();
        $message = Message::create([
            'chat_id' => $chatId,
            'user_id' => $user->id,
            'message' => $request->message,
        ]);

        return response()->json($message, 201);
    }

    public function index($chatId)
    {
        $messages = Message::where('chat_id', $chatId)->with('user')->get();

        return response()->json($messages, 200);
    }
}
