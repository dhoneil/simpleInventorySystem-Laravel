<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        DB::table('services')->insert(
        [
            'service_name' => 'Hair cut',
            'service_price' => 120,
        ]);

        DB::table('services')->insert(
        [
            'service_name' => 'Manicure',
            'service_price' => 120,
        ]);

        DB::table('services')->insert(
        [
            'service_name' => 'Pedicure',
            'service_price' => 150,
        ]);
    }
}
