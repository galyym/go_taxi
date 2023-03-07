<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\Driver;
use Illuminate\Database\Seeder;

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
        Car::factory(10)->create();
        Driver::factory(10)->create();
//        $this->call(UserSeeder::class);
//        $this->call(CitiesSeeder::class);
    }
}
