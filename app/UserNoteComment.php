<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserNoteComment extends Model
{
    protected $table = 'user_note_comments';

    protected $fillable = [
        'user_note_id',
        'user_id',
        'comment',
    ];

    /**
     * The note this comment belongs to.
     */
    public function note()
    {
        return $this->belongsTo(UserNote::class, 'user_note_id');
    }

    /**
     * The user who authored the comment.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
