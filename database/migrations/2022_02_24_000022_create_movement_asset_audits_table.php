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
        Schema::create('movement_asset_audits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('image')->nullable();
            $table->unsignedBigInteger('movement_asset_id');
            $table->integer('good_cond_qty');
            $table->integer('bad_cond_qty');
            $table->unsignedBigInteger('movement_asset_result_id');

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
        Schema::dropIfExists('movement_asset_audits');
    }
};
