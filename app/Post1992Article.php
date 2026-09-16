<?php

namespace App;

// use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;


class Post1992Article extends Model
{
    protected $fillable = [
        'part',
        'section',
        'content',
        'priority',
        'post_act',
        'act_id',
        'act_group',
    ];
}
