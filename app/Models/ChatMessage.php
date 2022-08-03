<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    use HasFactory;

    public function room(){
        return $this->hasOne(ChatRoom::class, 'id', 'chat_room_id');
    }

    public function user(){
        return $this->hasOne(user::class, 'id', 'user_id');
    }
}
