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
        Schema::create('sales_order_employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('store_id');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('delivery_address_id');
            $table->date('date');
            $table->bigInteger('total');
            $table->string('image')->nullable();
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
        Schema::dropIfExists('sales_order_employees');
    }
};
