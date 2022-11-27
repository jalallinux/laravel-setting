<?php

namespace JalalLinuX\Setting;

use Illuminate\Support\ServiceProvider;
use JalalLinuX\Setting\Services\SettingService;

class SettingServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('setting', SettingService::class);
    }

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }
}
