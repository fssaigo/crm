<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class SystemUserContextProvider extends ServiceProvider
{
    /**
     * 服务提供者加是否延迟加载.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->bind('Riak\Contracts\Connection', function ($app) {
            return new Connection(config('riak'));
        });

    }

}
