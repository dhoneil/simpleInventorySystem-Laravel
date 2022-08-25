<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert(
        [
            'product_name' => 'Gel',
            'product_price' => 50,
        ]);

        DB::table('products')->insert(
        [
            'product_name' => 'Cutix',
            'product_price' => 70,
        ]);

        DB::table('products')->insert(
        [
            'product_name' => 'Blower',
            'product_price' => 1200,
        ]);
    }
}
