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
        Schema::create('utility_bills', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('utility_id');
            $table->string('image')->nullable();
            $table->date('date');
            $table->string('amount')->nullable();
            $table->decimal('initial_indicator')->nullable();
            $table->decimal('last_indicator');

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
        Schema::dropIfExists('utility_bills');
    }
};
