<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@busticket.com',
            'email_verified_at' => '2021-10-27 07:23:38',
            'password' => Hash::make('123456789'),
            'role' => 1,
            'created_at' => '2021-10-28 00:43:47'
        ]);
    }
}
