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
        Schema::create('transfer_stocks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->string('image')->nullable();
            $table->unsignedBigInteger('from_store_id');
            $table->unsignedBigInteger('to_store_id');
            $table->tinyInteger('status');
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('approved_by_id')->nullable();
            $table->unsignedBigInteger('received_by_id');
            $table->unsignedBigInteger('sent_by_id');

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
        Schema::dropIfExists('transfer_stocks');
    }
};
