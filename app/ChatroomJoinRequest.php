<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatroomJoinRequest extends Model
{
    protected $fillable = [
        'chatroom_id',
        'user_id',
        'requester_name',
        'requester_email',
        'requester_phone',
        'note',
        'status',
    ];

    public function chatroom()
    {
        return $this->belongsTo(Chatroom::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
