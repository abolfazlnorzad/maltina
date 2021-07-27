<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Nrz\Product\Models\Product;
use Nrz\User\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        User::create([
            "name" => "admin",
            "email" => "admin@gmail.com",
            "password" => bcrypt("password"),
            "is_admin" => true
        ]);

    }
}
