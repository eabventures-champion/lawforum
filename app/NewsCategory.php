<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsCategory extends Model
{
    protected $fillable = [
        'name',
        'is_enabled',
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
    ];

    /**
     * Scope query to only enabled categories.
     */
    public function scopeEnabled($query)
    {
        return $query->where('is_enabled', true);
    }
}
