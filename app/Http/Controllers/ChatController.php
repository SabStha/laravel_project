<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $conversations = Conversation::where('jobseeker_id', $user->id)
            ->orWhere('employer_id', $user->id)
            ->with('messages')
            ->get();

        return view('index', compact('conversations'));
    }

    public function getMessages($conversationId)
    {
        $messages = Message::where('conversation_id', $conversationId)->get();
        return response()->json($messages);
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'conversation_id' => 'required|exists:conversations,id',
            'message' => 'required|string'
        ]);

        $message = Message::create([
            'conversation_id' => $request->conversation_id,
            'sender_id' => Auth::id(),
            'message' => $request->message,
            'is_read' => false
        ]);

        return response()->json($message);
    }

    public function start($id)
{
    $recipient = User::findOrFail($id);

    // Check if a conversation exists
    $conversation = Conversation::where(function ($query) use ($id) {
        $query->where('employer_id', Auth::id())
              ->where('jobseeker_id', $id);
    })->orWhere(function ($query) use ($id) {
        $query->where('jobseeker_id', Auth::id())
              ->where('employer_id', $id);
    })->first();

    // If no conversation exists, create a new one
    if (!$conversation) {
        $conversation = Conversation::create([
            'employer_id' => Auth::id(),
            'jobseeker_id' => $id,
        ]);
    }

    // Fetch all conversations for the current user
    $conversations = Conversation::where('employer_id', Auth::id())
        ->orWhere('jobseeker_id', Auth::id())
        ->with(['employer', 'jobseeker', 'messages'])
        ->get();

    // Fetch messages of the selected conversation
    $messages = Message::where('conversation_id', $conversation->id)
        ->orderBy('created_at', 'asc')
        ->get();

    return view('index', compact('recipient', 'conversation', 'conversations', 'messages'));
}

}

