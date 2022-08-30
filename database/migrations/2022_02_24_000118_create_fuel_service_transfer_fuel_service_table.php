<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fuel_service_transfer_fuel_service', function (
            Blueprint $table
        ) {
            $table->unsignedBigInteger('fuel_service_id');
            $table->unsignedBigInteger('transfer_fuel_service_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fuel_service_transfer_fuel_service');
    }
};
