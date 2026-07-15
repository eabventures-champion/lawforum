<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SidebarAd extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sidebar_ads';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slot_name',
        'title',
        'image_path',
        'target_url',
        'button_text',
        'is_active',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the full URL to the ad image.
     */
    public function getImageUrlAttribute()
    {
        if (!$this->image_path) {
            return null;
        }

        if (filter_var($this->image_path, FILTER_VALIDATE_URL)) {
            return $this->image_path;
        }

        return asset($this->image_path);
    }
}
