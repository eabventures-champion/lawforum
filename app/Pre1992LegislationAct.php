<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Pre1992LegislationAct extends Model
{
    protected $fillable = [
        'title',
        'preamble',
        'year',
        'pre_1992_group',
    ];
}
