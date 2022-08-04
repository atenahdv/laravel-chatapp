<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use App\Models\ChatRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\NewChatMessage;

class ChatController extends Controller
{
    public function rooms(Request $request){
        return ChatRoom::all();
    }
    public function messages(Request $request , $roomId){
        return ChatMessage::where('chat_room_id' , $roomId)
        ->with('user')
        ->orderBy('created_at','DESC')
        ->get();

    }

    public function newMessage(Request $request , $roomId){
        $newMessage = new ChatMessage;
        $newMessage->user_id = Auth::id();
        $newMessage->chat_room_id = $roomId;
        $newMessage->message = $request->message;
        $newMessage->save();

        broadcast(new NewChatMessage($newMessage))->toOthers();
        return $newMessage;
    }
}
