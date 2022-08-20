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
        Schema::create('production_froms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('purchase_order_product_id');
            $table->unsignedBigInteger('production_id');

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
        Schema::dropIfExists('production_froms');
    }
};
