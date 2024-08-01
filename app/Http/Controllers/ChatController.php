<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function store(Request $request)
    {
        $user = auth()->user();
        $chat = Chat::create(['user_id' => $user->id]);

        return response()->json($chat, 201);
    }

    public function index()
    {
        $user = auth()->user();
        $chats = Chat::where('user_id', $user->id)->with('messages')->get();

        return response()->json($chats, 200);
    }
}
