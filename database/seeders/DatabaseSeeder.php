<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\ServiceSeeder;
use Database\Seeders\CustomerSeeder;
use Database\Seeders\UserRoleSeeder;
use Database\Seeders\BeauticianSeeder;
use Database\Seeders\UserInformationSeeder;
use Symfony\Component\HttpKernel\DependencyInjection\ServicesResetter;

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
        $this->call(UserSeeder::class);
        $this->call(BeauticianSeeder::class);
        $this->call(ServiceSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(UserRoleSeeder::class);
    }
}
