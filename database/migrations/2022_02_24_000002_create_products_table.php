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
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('slug', 50);
            $table->string('sku')->nullable();
            $table->string('barcode')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->tinyInteger('request');
            $table->tinyInteger('remaining');
            $table->unsignedBigInteger('unit_id');
            $table->unsignedBigInteger('material_group_id');
            $table->unsignedBigInteger('franchise_group_id');
            $table->unsignedBigInteger('payment_type_id');
            $table->unsignedBigInteger('online_category_id');
            $table->unsignedBigInteger('product_group_id');
            $table->unsignedBigInteger('restaurant_category_id');
            $table->unsignedBigInteger('user_id');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
