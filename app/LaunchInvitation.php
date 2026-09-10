<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LaunchInvitation extends Model
{
    protected $fillable = [
        'email',
        'source',
        'ip_address',
        'user_agent',
        'is_notified',
    ];

    protected $casts = [
        'is_notified' => 'boolean',
    ];
}
