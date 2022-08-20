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
        Schema::create('utilities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('number')->unique();
            $table->string('name');
            $table->unsignedBigInteger('store_id');
            $table->tinyInteger('category');
            $table->unsignedBigInteger('unit_id');
            $table->unsignedBigInteger('utility_provider_id');
            $table->tinyInteger('pre_post');
            $table->tinyInteger('status');

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
        Schema::dropIfExists('utilities');
    }
};
