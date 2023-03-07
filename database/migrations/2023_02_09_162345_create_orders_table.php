<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('from_address')->nullable();
            $table->string('to_address')->nullable();
            $table->double('price', 8, 2)->nullable();
            $table->integer('user_id')->nullable();
            $table->timestamp('departure_time')->nullable();
            $table->integer('passenger_count')->nullable();
            $table->boolean('salon')->nullable();
            $table->boolean('round_trip')->nullable();
            $table->boolean('luggage')->nullable();
            $table->text('comment')->nullable();
            $table->integer('from_city_id')->nullable();
            $table->integer('to_city_id')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
