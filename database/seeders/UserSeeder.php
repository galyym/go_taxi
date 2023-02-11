<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
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
            "lastname" => Str::random(10),
            'name' => 'galyym',
            "patronymic" => "",
            "iin" => Str::random(12),
            'email' => Str::random(10).'@gmail.com',
            "phone_number" => '77758151708',
            "profile_photo" => "",
            "address" => "",
            'password' => Hash::make('123'),
            "remember_token" => "",
            "firebase_token" => "",
        ]);
    }
}
