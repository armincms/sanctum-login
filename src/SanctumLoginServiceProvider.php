<?php

namespace Armincms\SanctumLogin;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider; 

class SanctumLoginServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    { 
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->app->booted(function () {
            $this->routes();
        }); 
    }

    /**
     * Register the tool's routes.
     *
     * @return void
     */
    protected function routes()
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        Route::prefix('/api/login')->group(__DIR__.'/../routes/api.php'); 
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
