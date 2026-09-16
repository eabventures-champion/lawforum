<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class ExecutiveAct extends Model
{
    protected $fillable = [
        'title',
        'preamble',
        'year',
        'executive_group',
    ];
}
