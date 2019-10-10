<?php

namespace App\Providers;

use App\AtivacaoFornecedor;
use App\Fornecedor;
use App\Observers\AtivacaoFornecedorObserver;
use App\Observers\FornecedorObserver;
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
        Fornecedor::observe(FornecedorObserver::class);
        AtivacaoFornecedor::observe(AtivacaoFornecedorObserver::class);
    }
}
