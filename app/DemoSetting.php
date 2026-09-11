<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DemoSetting extends Model
{
    protected $table = 'demo_settings';

    protected $fillable = [
        'key',
        'value',
    ];

    protected static $cachedSettings = [];

    public static function get($key, $default = null)
    {
        if (isset(static::$cachedSettings[$key])) {
            return static::$cachedSettings[$key];
        }
        $setting = self::where('key', $key)->first();
        $val = $setting ? $setting->value : $default;
        static::$cachedSettings[$key] = $val;
        return $val;
    }

    public static function set($key, $value)
    {
        static::$cachedSettings[$key] = $value;
        return self::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }
}
