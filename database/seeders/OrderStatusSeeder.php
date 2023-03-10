<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rb_order_status')->insert([
            "name_kk" => "құрылды",
            "name_ru" => "создано",
            "name_en" => "created",
        ]);

        DB::table('rb_order_status')->insert([
            "name_kk" => "жаңартылды",
            "name_ru" => "обновлено",
            "name_en" => "updated",
        ]);

        DB::table('rb_order_status')->insert([
            "name_kk" => "аяқталды",
            "name_ru" => "завершенный",
            "name_en" => "completed",
        ]);

        DB::table('rb_order_status')->insert([
            "name_kk" => "қателік",
            "name_ru" => "ошибка",
            "name_en" => "error",
        ]);
    }
}
