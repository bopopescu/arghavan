<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFingerprintDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fingerprint_devices', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('ip');
            $table->integer('port');
            $table->string('name');
            $table->boolean('net_state');
            $table->boolean('enabled');
            $table->json('extra')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fingerprint_devices');
    }
}
