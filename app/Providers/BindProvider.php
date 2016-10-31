<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class BindProvider extends ServiceProvider
{
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

        //注册Service
        $this->app->bind('App\Http\Repositories\Services\IGroup', 'App\Http\Repositories\Services\Impls\GroupService');
        $this->app->bind('App\Http\Repositories\Services\IUser', 'App\Http\Repositories\Services\Impls\UserService');
        $this->app->bind('App\Http\Repositories\Services\IMerchant', 'App\Http\Repositories\Services\Impls\MerchantService');
        $this->app->bind('App\Http\Repositories\Services\IChannel', 'App\Http\Repositories\Services\Impls\ChannelService');
        $this->app->bind('App\Http\Repositories\Services\IPond', 'App\Http\Repositories\Services\Impls\PondService');
        $this->app->bind('App\Http\Repositories\Services\ICustomer', 'App\Http\Repositories\Services\Impls\CustomerService');
        $this->app->bind('App\Http\Repositories\Services\IMenu', 'App\Http\Repositories\Services\Impls\MenuService');
        $this->app->bind('App\Http\Repositories\Services\IDistribution', 'App\Http\Repositories\Services\Impls\DistributionService');
/**
        $this->app->singleton('App\Http\Repositories\Daos\IUserDao', function ($app) {
            return new \App\Http\Repositories\Daos\Impls\UserDao();
        });
*/
        //注册Dao类
        $this->app->bind('App\Http\Repositories\Daos\IUserDao', 'App\Http\Repositories\Daos\Impls\UserDao');
        $this->app->bind('App\Http\Repositories\Daos\IGroupDao', 'App\Http\Repositories\Daos\Impls\GroupDao');
        $this->app->bind('App\Http\Repositories\Daos\IMerchantDao', 'App\Http\Repositories\Daos\Impls\MerchantDao');
        $this->app->bind('App\Http\Repositories\Daos\IPondDao', 'App\Http\Repositories\Daos\Impls\PondDao');
        $this->app->bind('App\Http\Repositories\Daos\ICustomerDao', 'App\Http\Repositories\Daos\Impls\CustomerDao');
        $this->app->bind('App\Http\Repositories\Daos\ICustomerMarkDao', 'App\Http\Repositories\Daos\Impls\CustomerMarkDao');
        $this->app->bind('App\Http\Repositories\Daos\IChannelDao', 'App\Http\Repositories\Daos\Impls\ChannelDao');
        $this->app->bind('App\Http\Repositories\Daos\IChinaDao', 'App\Http\Repositories\Daos\Impls\ChinaDao');
        $this->app->bind('App\Http\Repositories\Daos\ICustomerVisitDao', 'App\Http\Repositories\Daos\Impls\CustomerVisitDao');
        $this->app->bind('App\Http\Repositories\Daos\IMenuDao', 'App\Http\Repositories\Daos\Impls\MenuDao');
        $this->app->bind('App\Http\Repositories\Daos\IMenuPermissionDao', 'App\Http\Repositories\Daos\Impls\MenuPermissionDao');

        //注册门面模式
        $this->app->bind('MerchantService', function () {
            return $this->app->make('App\Http\Repositories\Services\IMerchant');
        });

    }


}
