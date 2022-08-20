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
        Schema::create('sales_order_onlines', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('image')->nullable();
            $table->unsignedBigInteger('store_id');
            $table->unsignedBigInteger('online_shop_provider_id');
            $table->date('date');
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->string('receipt_no')->nullable();
            $table->bigInteger('total')->nullable();
            $table->tinyInteger('status');
            $table->text('notes');
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
        Schema::dropIfExists('sales_order_onlines');
    }
};
