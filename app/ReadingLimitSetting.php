<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReadingLimitSetting extends Model
{
    protected $table = 'reading_limit_settings';

    protected $fillable = [
        'key',
        'value',
    ];

    /**
     * Get a setting value by key with optional fallback default.
     */
    public static function get($key, $default = null)
    {
        try {
            $setting = self::where('key', $key)->first();
            return ($setting && $setting->value !== null && $setting->value !== '') ? $setting->value : $default;
        } catch (\Exception $e) {
            return $default;
        }
    }

    /**
     * Set a setting key-value pair.
     */
    public static function set($key, $value)
    {
        return self::updateOrCreate(
            ['key' => $key],
            ['value' => (string) $value]
        );
    }
}
