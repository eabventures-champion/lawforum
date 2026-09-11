<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Subscription extends Model
{
    protected $table = 'subscriptions';

    protected $fillable = [
        'type',
        'general_notes',
        'specific_notes',
        'price',
        'duration',
        'no_downloads',
        'is_active',
        'is_button_disabled',
        'is_popular',
        'badge',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'duration' => 'integer',
        'no_downloads' => 'integer',
        'is_active' => 'boolean',
        'is_button_disabled' => 'boolean',
        'is_popular' => 'boolean',
    ];
}
