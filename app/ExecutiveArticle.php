<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class ExecutiveArticle extends Model
{
    protected $fillable = [
        'part',
        'section',
        'content',
        'priority',
        'executive_act',
        'executive_act_id',
        'executive_group',
    ];
}
