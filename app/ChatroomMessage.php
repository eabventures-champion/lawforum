<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatroomMessage extends Model
{
    protected $fillable = [
        'chatroom_id', 'user_id', 'guest_name', 'message', 'parent_id'
    ];

    public function chatroom()
    {
        return $this->belongsTo(Chatroom::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        return $this->belongsTo(ChatroomMessage::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(ChatroomMessage::class, 'parent_id')->orderBy('created_at', 'asc');
    }

    public function getAuthorNameAttribute()
    {
        if ($this->user) {
            return $this->user->name;
        }
        return $this->guest_name ?: 'Guest Contributor';
    }

    public function getAuthorRoleAttribute()
    {
        if ($this->user) {
            if ($this->user->isAdmin()) return 'Admin';
            return ucfirst($this->user->user_type ?: 'Member');
        }
        return 'Guest User';
    }
}
