<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class BeauticianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('beauticians')->insert(
        [
            'firstname' => 'David',
            'middlename' => '',
            'lastname' => 'SalonGomez',
        ]);

        DB::table('beauticians')->insert(
        [
            'firstname' => 'Robert',
            'middlename' => '',
            'lastname' => 'De Niro',
        ]);

        DB::table('beauticians')->insert(
        [
            'firstname' => 'Dana',
            'middlename' => '',
            'lastname' => 'White',
        ]);
    }
}
