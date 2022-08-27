<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dymsaid = DB::table('users')->insertGetId(
        [
            'name' => 'Dymsa Tarrosa',
            'email' => 'dymsa@gmail.com',
            'password' => '$2y$10$rcjGoY6S9xVH.xb/J8/R7unO32eDQ6a9.xPov16ftP.Tl/HsJO26i',
            'role_id' => 1
        ]);
        DB::table('user_information')->insertGetId(
        [
            'user_id' => $dymsaid,
            'firstname' => 'Dymsa',
            'middlename' => '',
            'lastname' => 'Tarrosa'
        ]);
        //==================================

        $id1 = DB::table('users')->insertGetId(
        [
            'name' => 'Dhoneil Angchangco',
            'email' => 'act.dangchangco@gmail.com',
            'password' => '$2y$10$KMjSzMsAQ/F7FOq6eLgR2.rKHQbOftgxH73wPmO0aT/FBw4FPMIBe',
            'role_id' => 1
        ]);
        DB::table('user_information')->insertGetId(
        [
            'user_id' => $id1,
            'firstname' => 'Dhoneil',
            'middlename' => '',
            'lastname' => 'Angchangco'
        ]);
        //==================================
    }
}
