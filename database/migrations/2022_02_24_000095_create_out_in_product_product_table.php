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
        Schema::create('out_in_product_product', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('out_in_product_id');
            $table->decimal('quantity');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('out_in_product_product');
    }
};
