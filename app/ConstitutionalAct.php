<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class ConstitutionalAct extends Model
{
    protected $fillable = [
        'title',
        'preamble',
        'year',
        'constitutional_group',
    ];
}
