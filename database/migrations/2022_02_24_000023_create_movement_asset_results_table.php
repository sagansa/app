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
        Schema::create('movement_asset_results', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('store_id');
            $table->date('date');
            $table->tinyInteger('status');
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();

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
        Schema::dropIfExists('movement_asset_results');
    }
};
