<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class NewsContent extends Model
{
    protected $fillable = [
        'title',
        'content',
        'extract',
        'news_category',
        'image',
    ];
}
