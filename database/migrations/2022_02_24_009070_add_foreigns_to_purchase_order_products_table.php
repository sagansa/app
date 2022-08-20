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
        Schema::table('purchase_order_products', function (Blueprint $table) {
            $table
                ->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('purchase_order_id')
                ->references('id')
                ->on('purchase_orders')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('unit_id')
                ->references('id')
                ->on('units')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchase_order_products', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropForeign(['purchase_order_id']);
            $table->dropForeign(['unit_id']);
        });
    }
};
