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
        Schema::create('presences', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('closing_store_id');
            $table->bigInteger('amount');
            $table->unsignedBigInteger('payment_type_id');
            $table->tinyInteger('status');
            $table->string('image_in')->nullable();
            $table->string('image_out')->nullable();
            $table->string('lat_long_in')->nullable();
            $table->string('lat_long_out');
            $table->unsignedBigInteger('created_by_id')->nullable();
            $table->unsignedBigInteger('approved_by_id')->nullable();

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
        Schema::dropIfExists('presences');
    }
};
