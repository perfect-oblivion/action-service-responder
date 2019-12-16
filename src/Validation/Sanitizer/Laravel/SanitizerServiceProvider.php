<?php
/**
 * File copied from Waavi/Sanitizer https://github.com/waavi/sanitizer
 * Sanitization functionality to be customized within this project before a 1.0 release.
 */

namespace PerfectOblivion\ActionServiceResponder\Validation\Sanitizer\Laravel;

use Illuminate\Support\ServiceProvider;

class SanitizerServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->singleton('sanitizer', function ($app) {
            return new Factory;
        });
    }
}
