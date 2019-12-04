<?php

namespace App\Providers;

use App\Helper\SupplierActivationHelper;
use App\Observers\SupplierActivationObserver;
use App\Observers\SupplierObserver;
use App\Supplier;
use App\SupplierActivation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        //Eloquent Observer
        Supplier::observe(SupplierObserver::class);
        SupplierActivation::observe(SupplierActivationObserver::class);

        //Singletons
        $this->app->singleton(SupplierActivationHelper::class, function ($app) {
            return new SupplierActivationHelper();
        });
    }
}
