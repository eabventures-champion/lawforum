<?php

if (!function_exists('setting')) {
    /**
     * Get Voyager setting fallback or config value.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function setting($key, $default = null) {
        if ($key === 'site.title') {
            return config('app.name', 'Legals Forum');
        }
        return $default;
    }
}

if (!function_exists('homepage_setting')) {
    /**
     * Get homepage setting value.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function homepage_setting($key, $default = null) {
        try {
            $setting = \App\HomepageSetting::where('key', $key)->first();
            if ($setting) {
                if ($setting->type === 'boolean') {
                    return (bool) $setting->value;
                }
                return $setting->value;
            }
        } catch (\Exception $e) {
            // Fallback
        }
        return $default;
    }
}

if (!function_exists('maintenance_setting')) {
    /**
     * Get maintenance setting value.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function maintenance_setting($key, $default = null) {
        try {
            $setting = \App\MaintenanceSetting::where('key', $key)->first();
            if ($setting) {
                if ($setting->type === 'boolean') {
                    return (bool) $setting->value;
                }
                if ($setting->type === 'json') {
                    return json_decode($setting->value, true) ?: $default;
                }
                return $setting->value;
            }
        } catch (\Exception $e) {
            // Fallback if table doesn't exist yet
        }
        return $default;
    }
}
