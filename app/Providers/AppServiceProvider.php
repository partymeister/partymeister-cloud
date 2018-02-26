<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->overrideDbPort();
    }

    /**
     * Override the database port under conditions
     */
    public function overrideDbPort()
    {
        if ($this->app->isLocal() && $this->app->runningInConsole()) {
            // Override the port so you can tunnel into homestead.
            if ($port = config('database.host-port')) {
                config()->set('database.connections.mysql.port', $port);
            }
        }
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
