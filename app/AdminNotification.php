<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminNotification extends Model
{
    protected $fillable = ['type', 'data', 'read_at'];

    protected $casts = [
        'data' => 'array'
    ];
}
