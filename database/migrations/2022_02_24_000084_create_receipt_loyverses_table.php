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
        Schema::create('receipt_loyverses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->string('receipt_number')->unique();
            $table->string('receipt_type');
            $table->string('gross_sales');
            $table->string('discounts');
            $table->string('net_sales');
            $table->string('taxes');
            $table->string('total_collected');
            $table->string('cost_of_goods');
            $table->string('gross_profit');
            $table->string('payment_type');
            $table->text('description');
            $table->string('dining_option');
            $table->string('pos');
            $table->string('store');
            $table->string('cashier_name');
            $table->string('customer_name')->nullable();
            $table->string('customer_contacts')->nullable();
            $table->string('status');

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
        Schema::dropIfExists('receipt_loyverses');
    }
};
