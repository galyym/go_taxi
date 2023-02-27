<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string("name_kk")->nullable();
            $table->string("name_ru")->nullable();
            $table->string("name_en")->nullable();
            $table->string("city_id")->unique();
            $table->string("city_coordinate")->unique();
            $table->string("city_radius")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cities');
    }
}
