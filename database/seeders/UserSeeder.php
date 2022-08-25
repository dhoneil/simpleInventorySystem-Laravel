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
            'password' => '$2y$10$KMjSzMsAQ/F7FOq6eLgR2.rKHQbOftgxH73wPmO0aT/FBw4FPMIBe',
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


        $id2 = DB::table('users')->insertGetId(
        [
            'name' => 'Jonathan Majel',
            'email' => 'act.jmajel@gmail.com',
            'password' => '$2y$10$KMjSzMsAQ/F7FOq6eLgR2.rKHQbOftgxH73wPmO0aT/FBw4FPMIBe',
            'role_id' => 3
        ]);
        DB::table('user_information')->insertGetId(
        [
            'user_id' => $id2,
            'firstname' => 'Jonathan',
            'middlename' => '',
            'lastname' => 'Majel'
        ]);
        //==================================



        $id3 = DB::table('users')->insertGetId(
        [
            'name' => 'Justin Dondon',
            'email' => 'act.jdondon@gmail.com',
            'password' => '$2y$10$KMjSzMsAQ/F7FOq6eLgR2.rKHQbOftgxH73wPmO0aT/FBw4FPMIBe',
            'role_id' => 3
        ]);
        DB::table('user_information')->insertGetId(
        [
            'user_id' => $id3,
            'firstname' => 'Justin',
            'middlename' => '',
            'lastname' => 'Dondon'
        ]);
        //==================================





        $id4 = DB::table('users')->insertGetId(
        [
            'name' => 'Marvin Caparida',
            'email' => 'act.mcaparida@gmail.com',
            'password' => '$2y$10$KMjSzMsAQ/F7FOq6eLgR2.rKHQbOftgxH73wPmO0aT/FBw4FPMIBe',
            'role_id' => 3
        ]);
        DB::table('user_information')->insertGetId(
        [
            'user_id' => $id4,
            'firstname' => 'Marvin',
            'middlename' => '',
            'lastname' => 'Caparida'
        ]);
        //==================================

    }
}
