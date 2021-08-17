<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('trip_type_id')->unsigned();
            $table->integer('vehicle_id')->unsigned();
            $table->integer('driver_id')->unsigned();
            $table->dateTime('request_date');
            $table->string('pickup_lat');
            $table->string('pickup_lng');
            $table->string('pickup_location');
            $table->dateTime('pickup_date');
            $table->string('dropoff_lat');
            $table->string('dropoff_lng');
            $table->string('dropoff_location');
            $table->dateTime('dropoff_date')->nullable();
            $table->integer('driver_rating')->nullable();
            $table->string('status');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('trip_type_id')
                ->references('id')
                ->on('trip_types')
                ->cascadeOnDelete();
            $table->foreign('vehicle_id')
                ->references('id')
                ->on('vehicles')
                ->cascadeOnDelete();
            $table->foreign('driver_id')
                ->references('id')
                ->on('drivers')
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
        Schema::dropIfExists('trips');
    }
}
