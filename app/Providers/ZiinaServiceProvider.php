<?php

namespace App\Providers;

use App\Services\ZiinaPaymentService;
use Illuminate\Support\ServiceProvider;

class ZiinaServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        // Register the Ziina service as a singleton
        $this->app->singleton(ZiinaPaymentService::class, function ($app) {
            return new ZiinaPaymentService();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Publish config file
        $this->publishes([
            __DIR__ . '/../config/ziina.php' => config_path('ziina.php'),
        ], 'ziina-config');
    }
}
