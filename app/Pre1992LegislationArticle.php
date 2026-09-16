<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Pre1992LegislationArticle extends Model
{
    protected $fillable = [
        'part',
        'section',
        'content',
        'priority',
        'pre_1992_act',
        'act_id',
        'act_group',
    ];
}
