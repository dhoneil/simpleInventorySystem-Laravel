<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('item_codes')->insert(
        [
            'item_code_name' => 'AVONXXL',
            'is_active' => true,
        ]);

        DB::table('item_codes')->insert(
        [
            'item_code_name' => 'AVONLAR',
            'is_active' => true,
        ]);

        DB::table('item_codes')->insert(
        [
            'item_code_name' => 'AVONXL',
            'is_active' => true,
        ]);
    }
}
