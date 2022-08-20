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
        Schema::create('purchase_order_purchase_receipt', function (
            Blueprint $table
        ) {
            $table->unsignedBigInteger('purchase_order_id');
            $table->unsignedBigInteger('purchase_receipt_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_order_purchase_receipt');
    }
};
