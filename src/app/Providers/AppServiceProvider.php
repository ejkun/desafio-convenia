<?php

namespace App\Providers;

use App\SupplierActivation;
use App\Supplier;
use App\Observers\SupplierActivationObserver;
use App\Observers\SupplierObserver;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //Eloquent Observer
        Supplier::observe(SupplierObserver::class);
        SupplierActivation::observe(SupplierActivationObserver::class);
    }
}
