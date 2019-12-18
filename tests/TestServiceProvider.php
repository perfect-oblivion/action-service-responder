<?php

namespace PerfectOblivion\ActionServiceResponder\Tests;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class TestServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        $this->routes();
    }

    public function routes()
    {
        Route::middleware('web')
             ->namespace('')
             ->group(__DIR__.'/Stubs/routes/actions.php');
    }
}
