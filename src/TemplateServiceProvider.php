<?php

namespace Thepany\Template;

use Illuminate\Support\ServiceProvider;
use Thepany\Template\Locale\Custom_Currency;
use NumberToWords\Legacy\Numbers\Words\Locale\Es;

class TemplateServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/template.php', 'template');
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/template.php' => config_path('template.php'),
        ], 'template.config');
    }
}
