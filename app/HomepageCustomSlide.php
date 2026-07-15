<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HomepageCustomSlide extends Model
{
    protected $table = 'homepage_custom_slides';

    protected $fillable = [
        'title',
        'subtitle',
        'content',
        'btn_text',
        'btn_link',
        'icon',
        'order',
        'is_published',
        'is_coming_soon',
    ];
}
