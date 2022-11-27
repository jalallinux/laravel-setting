<?php

use JalalLinuX\Setting\Services\SettingService;

if (! function_exists('is_json')) {
    /**
     * @param  string  $string
     * @return bool
     *
     * @author JalalLinuX
     */
    function is_json(string $string): bool
    {
        json_decode($string);

        return json_last_error() === JSON_ERROR_NONE;
    }
}

if (! function_exists('setting')) {
    function setting(bool $system = null): SettingService
    {
        $service = new SettingService();

        if ($system) {
            $service = $service->system();
        }

        return $service;
    }
}
