<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdditionalMenuSetting extends Model
{
    protected $table = 'additional_menu_settings';

    protected $fillable = ['key', 'value'];

    /**
     * Get a setting value with fallback default
     */
    public static function get($key, $default = null)
    {
        try {
            $setting = static::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        } catch (\Exception $e) {
            return $default;
        }
    }

    /**
     * Set a setting value
     */
    public static function set($key, $value)
    {
        return static::updateOrCreate(
            ['key' => $key],
            ['value' => (string) $value]
        );
    }

    /**
     * Check if a specific menu or subcategory is enabled
     */
    public static function isEnabled($key, $default = true)
    {
        $val = static::get($key, $default ? '1' : '0');
        return $val === '1' || $val === true || $val === 1 || $val === 'true';
    }

    /**
     * Get all settings as key-value array
     */
    public static function getAllSettings()
    {
        try {
            return static::pluck('value', 'key')->toArray();
        } catch (\Exception $e) {
            return [];
        }
    }
}
