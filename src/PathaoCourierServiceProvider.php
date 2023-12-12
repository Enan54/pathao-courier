<?php

namespace Enan\PathaoCourier;

// use Spatie\LaravelPackageTools\Package;
// use Spatie\LaravelPackageTools\PackageServiceProvider;
use Illuminate\Support\ServiceProvider;
use Enan\PathaoCourier\Commands\PathaoCourierCommand;

class PathaoCourierServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/pathao-courier.php',
            'courier'
        );
    }

    /**
     * Bootstrap any package services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/pathao-courier.php' => config_path('pathao-courier.php')
        ], 'pathao-courier-config');
        $this->publishes([
            __DIR__ . '/../database' => database_path('migrations'),
        ], 'migrations');
    }
}
