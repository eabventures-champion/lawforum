<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $table = 'subscriptions';

    protected $fillable = [
        'type',
        'currency',
        'price',
        'duration',
        'duration_text',
        'no_downloads',
        'max_users',
        'highlight_text',
        'features',
        'general_notes',
        'specific_notes',
        'badge',
        'button_text',
        'is_active',
        'is_button_disabled',
        'is_popular',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'duration' => 'integer',
        'no_downloads' => 'integer',
        'max_users' => 'integer',
        'is_active' => 'boolean',
        'is_button_disabled' => 'boolean',
        'is_popular' => 'boolean',
        'features' => 'array',
    ];

    /**
     * Get the array of features for this subscription plan.
     */
    public function getFeatureListAttribute(): array
    {
        if (!empty($this->features) && is_array($this->features)) {
            return array_values(array_filter(array_map('trim', $this->features)));
        }

        // Fallback for legacy records
        $list = [];
        if (!empty($this->general_notes)) {
            $list[] = trim($this->general_notes);
        }
        if (!empty($this->specific_notes)) {
            $list[] = trim($this->specific_notes);
        }
        $list[] = 'High-Speed Official PDF Document Downloads';
        $list[] = 'Search Filter & Section Bookmarking';
        $list[] = 'Personal Document Notes & Annotations';

        return $list;
    }

    /**
     * Get the display duration label (e.g. "for 3 months", "per year").
     */
    public function getDisplayDurationAttribute(): string
    {
        if (!empty($this->duration_text)) {
            return $this->duration_text;
        }

        $durationDays = (int) $this->duration;
        if ($durationDays >= 365) {
            return 'per year';
        } elseif ($durationDays >= 180) {
            return 'for 6 months';
        } elseif ($durationDays >= 90) {
            return 'for 3 months';
        } elseif ($durationDays >= 30) {
            return 'per month';
        }

        return 'per ' . $durationDays . ' days';
    }

    /**
     * Get the display highlight text (e.g. "Up to 50 document downloads").
     */
    public function getDisplayHighlightAttribute(): string
    {
        if (!empty($this->highlight_text)) {
            return $this->highlight_text;
        }

        if ((int) $this->no_downloads >= 10000) {
            return 'Unlimited document downloads';
        }

        return 'Up to ' . number_format($this->no_downloads) . ' document downloads';
    }

    /**
     * Get the display button text (defaults to "Subscribe Now").
     */
    public function getDisplayButtonTextAttribute(): string
    {
        return !empty($this->button_text) ? $this->button_text : 'Subscribe Now';
    }

    /**
     * Get human-readable seats/user limit (e.g. "1 User", "3 Team Users", "5 Team Users").
     */
    public function getDisplaySeatsAttribute(): string
    {
        $seats = (int) ($this->max_users ?: 1);
        if ($seats === 1) {
            return '1 User';
        }
        return $seats . ' Team Users';
    }
}
