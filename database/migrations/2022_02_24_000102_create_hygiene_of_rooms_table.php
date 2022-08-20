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
        Schema::create('hygiene_of_rooms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('hygiene_id');
            $table->unsignedBigInteger('room_id');
            $table->string('image')->nullable();

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
        Schema::dropIfExists('hygiene_of_rooms');
    }
};
