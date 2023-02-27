<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cities')->insert([
            "name_kk" => "Ақтау",
            'name_ru' => 'Актау',
            "name_en" => "Aqtau",
            "city_id" => 1,
            'city_coordinate' => "43.656464, 51.237905",
            "city_radius" => '10000',
        ]);

        DB::table('cities')->insert([
            "name_kk" => "Жаңаөзен",
            'name_ru' => 'Жанаозен',
            "name_en" => "Zhanaozen",
            "city_id" => 2,
            'city_coordinate' => "43.341507, 52.854764",
            "city_radius" => '10000',
        ]);

        DB::table('cities')->insert([
            "name_kk" => "Шетпе",
            'name_ru' => 'Шетпе',
            "name_en" => "Shetpe",
            "city_id" => 3,
            'city_coordinate' => "44.138699, 52.160790",
            "city_radius" => '5000',
        ]);

        DB::table('cities')->insert([
            "name_kk" => "Жетібай",
            'name_ru' => 'Жетибай',
            "name_en" => "Zhetybay",
            "city_id" => 4,
            'city_coordinate' => "43.590553, 52.101073",
            "city_radius" => '5000',
        ]);
    }
}
