<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OnboardingTourStep extends Model
{
    protected $table = 'onboarding_tour_steps';

    protected $fillable = [
        'step_number',
        'badge_label',
        'title',
        'description',
        'icon',
        'highlight_title',
        'highlight_text',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'step_number' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('step_number', 'asc');
    }
}
