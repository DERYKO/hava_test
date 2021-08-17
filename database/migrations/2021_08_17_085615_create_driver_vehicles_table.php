<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriverVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('driver_vehicles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('driver_id')->unsigned();
            $table->integer('vehicle_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('driver_id')
                ->references('id')
                ->on('drivers')
                ->cascadeOnDelete();
            $table->foreign('vehicle_id')
                ->references('id')
                ->on('vehicles')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('driver_vehicles');
    }
}
