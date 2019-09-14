<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrafficDaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('traffic_days', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('index');
            $table->string('name');
            $table->time("begin_time");
            $table->integer("begin_number");
            $table->time("end_time");
            $table->integer("end_number");
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
        Schema::dropIfExists('traffic_days');
    }
}
