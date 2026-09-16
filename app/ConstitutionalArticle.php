<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class ConstitutionalArticle extends Model
{
    protected $fillable = [
        'part',
        'section',
        'content',
        'priority',
        'constitutional_act',
        'consti_act_id',
        'consti_group',
    ];
}
