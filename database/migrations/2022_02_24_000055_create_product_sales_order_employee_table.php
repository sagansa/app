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
        Schema::create('product_sales_order_employee', function (
            Blueprint $table
        ) {
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('sales_order_employee_id');
            $table->decimal('quantity');
            $table->bigInteger('unit_price');

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
        Schema::dropIfExists('product_sales_order_employee');
    }
};
