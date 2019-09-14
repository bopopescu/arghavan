<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gate_plans', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger("traffic_day_id");
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('traffic_day_id')
                    ->references('id')
                    ->on('traffic_days')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gate_plans');
    }
}
