<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemGenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('item_genres')->insert(
        [
            'item_genre_name' => 'APPAREL',
            'is_active' => true,
        ]);

        DB::table('item_genres')->insert(
        [
            'item_genre_name' => 'BAG',
            'is_active' => true,
        ]);
    }
}
