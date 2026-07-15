<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NavigationMenu extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'navigation_menus';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'slug',
        'url',
        'order',
        'is_active',
        'is_dropdown',
        'parent_id',
        'custom_content'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean',
        'is_dropdown' => 'boolean',
        'order' => 'integer',
        'parent_id' => 'integer'
    ];

    /**
     * Get the parent menu item.
     */
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * Get the sub-menu items (children).
     */
    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }
}
