<?php

namespace Nrz\User\Providers;

use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->loadRoutesFrom(__DIR__."/../Routes/user_route.php");
        $this->loadMigrationsFrom(__DIR__."/../Database/Migrations");

    }

    public function boot()
    {

    }

}
