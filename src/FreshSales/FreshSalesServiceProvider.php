<?php

namespace APN\FreshSales;

use APN\ConnectorInterface;
use Illuminate\Support\ServiceProvider;

class FreshSalesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     * Inject your connector here.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ConnectorInterface::class, function () {
           return new FreshSales(
               config('freshsales.api_key'),
               config('freshsales.domain')
           );
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $configPath = __DIR__ . '/../config/freshsales.php';
        $this->publishes([
            $configPath => config_path('freshsales.php'), ]);
    }
}
