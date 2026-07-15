<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HomepageSetting extends Model
{
    protected $table = 'homepage_settings';

    protected $fillable = [
        'key',
        'value',
        'label',
        'type',
        'group',
    ];
}
