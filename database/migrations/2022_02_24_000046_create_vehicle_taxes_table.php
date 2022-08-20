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
        Schema::create('vehicle_taxes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('image')->nullable();
            $table->unsignedBigInteger('vehicle_id');
            $table->bigInteger('amount_tax');
            $table->date('expired_date');
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('user_id');

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
        Schema::dropIfExists('vehicle_taxes');
    }
};
