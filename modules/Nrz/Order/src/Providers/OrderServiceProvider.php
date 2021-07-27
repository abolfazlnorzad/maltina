<?php

namespace Nrz\Order\Providers;


use Illuminate\Support\ServiceProvider;

class OrderServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->loadMigrationsFrom(__DIR__."/../Database/Migrations");
        $this->loadRoutesFrom(__DIR__."/../Routes/order_routes.php");
    }

    public function boot()
    {

    }

}
