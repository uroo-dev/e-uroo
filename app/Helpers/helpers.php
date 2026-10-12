<?php

use App\Models\Setting;

if (! function_exists('setting')) {
    /**
     * Get a website or system setting with optional fallback.
     */
    function setting(string $key, ?string $default = null): ?string
    {
        return Setting::get($key, $default);
    }
}
