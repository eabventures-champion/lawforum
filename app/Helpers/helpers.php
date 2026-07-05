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
            return config('app.name', 'LawsGhana');
        }
        return $default;
    }
}
