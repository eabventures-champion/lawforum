<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class UserBookmark extends Model
{
    protected $fillable = [
        'user_id',
        'user_name',
        'act_title',
        'act_section',
        'section_id',
        'act_id',
        'act_group',
        'user_section',
        'document_type',
        'page_url',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
