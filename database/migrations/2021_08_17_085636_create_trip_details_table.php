<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trip_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('trip_id')->unsigned();
            $table->float('duration');
            $table->string('duration_unit');
            $table->float('distance');
            $table->string('distance_unit');
            $table->float('cost');
            $table->string('cost_unit');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('trip_id')
                ->references('id')
                ->on('trips')
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
        Schema::dropIfExists('trip_details');
    }
}
