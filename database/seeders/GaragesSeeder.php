<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GaragesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('garages')->insert([
            'name_garage' => 'Bến Xe Yên Nghĩa',
            'path_of_banner' => '/uploads/garages/1/banner.jpg',
            'phone' => '123456789',
            'address' => 'Hà Đông, Hà Nội'
        ]);
    }
}
