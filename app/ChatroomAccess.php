<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatroomAccess extends Model
{
    protected $fillable = [
        'chatroom_id',
        'user_id',
        'session_id',
        'access_method',
        'unlocked_at',
    ];

    protected $casts = [
        'unlocked_at' => 'datetime',
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
