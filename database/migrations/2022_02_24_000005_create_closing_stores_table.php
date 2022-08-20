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
        Schema::create('closing_stores', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('store_id');
            $table->unsignedBigInteger('shift_store_id');
            $table->date('date');
            $table->bigInteger('cash_from_yesterday');
            $table->bigInteger('cash_for_tomorrow');
            $table->unsignedBigInteger('transfer_by_id');
            $table->bigInteger('total_cash_transfer');
            $table->tinyInteger('status');
            $table->text('notes')->nullable();
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
        Schema::dropIfExists('closing_stores');
    }
};
