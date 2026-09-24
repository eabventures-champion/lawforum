<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserNote extends Model
{
    protected $fillable = [
        'user_id', 'document_type', 'document_id', 'document_title',
        'highlighted_text', 'note_content', 'note_color',
        'article_section', 'page_url'
    ];

    /**
     * Get the user that owns the note.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get comments/discussion on this note.
     */
    public function comments()
    {
        return $this->hasMany(UserNoteComment::class, 'user_note_id')->orderBy('created_at', 'asc');
    }
}
