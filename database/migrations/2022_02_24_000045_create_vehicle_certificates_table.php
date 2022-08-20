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
        Schema::create('vehicle_certificates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('vehicle_id');
            $table->tinyInteger('BPKB');
            $table->tinyInteger('STNK');
            $table->string('name');
            $table->string('brand');
            $table->string('type');
            $table->string('category');
            $table->string('model');
            $table->year('manufacture_year');
            $table->string('cylinder_capacity');
            $table->string('vehilce_identity_no');
            $table->string('engine_no');
            $table->string('color', 255);
            $table->string('type_fuel');
            $table->string('lisence_plate_color');
            $table->string('registration_year');
            $table->string('bpkb_no');
            $table->string('location_code');
            $table->string('registration_queue_no');
            $table->text('notes')->nullable();

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
        Schema::dropIfExists('vehicle_certificates');
    }
};
