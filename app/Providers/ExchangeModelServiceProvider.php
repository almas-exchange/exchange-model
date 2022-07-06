<?php

namespace ExchangeModel\Providers;

use Illuminate\Support\ServiceProvider;

class ExchangeModelServiceProvider extends ServiceProvider
{
    public function register()
    {
        if ($this->app instanceof \Illuminate\Foundation\Application) {
            $this->publishes([
                __DIR__.'/../../config/exchange-model.php' => config_path('exchange-model.php'),
            ], 'exchange-model');
        } else {
            $this->publishes([
                __DIR__.'/../../config/exchange-model.php' => app()->basePath() . '/config/exchange-model.php',
            ], 'exchange-model');
        }
    }

    public function boot()
    {
        //
    }
}