<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class WaterTemperature extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('water_temperature', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tank_1');
            $table->string('tank_2');
            $table->string('tank_3');
            $table->text('note')->nullable();
            $table->string('name')->nullable();
            $table->string('date');
            $table->string('time');
            $table->string('photo')->nullable();
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
        Schema::dropIfExists('water_temperature');
    }
}
