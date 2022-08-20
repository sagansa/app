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
        Schema::table('sales_order_employees', function (Blueprint $table) {
            $table
                ->foreign('store_id')
                ->references('id')
                ->on('stores')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('customer_id')
                ->references('id')
                ->on('customers')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('delivery_address_id')
                ->references('id')
                ->on('delivery_addresses')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('created_by_id')
                ->references('id')
                ->on('users')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('approved_by_id')
                ->references('id')
                ->on('users')
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
        Schema::table('sales_order_employees', function (Blueprint $table) {
            $table->dropForeign(['store_id']);
            $table->dropForeign(['customer_id']);
            $table->dropForeign(['delivery_address_id']);
            $table->dropForeign(['created_by_id']);
            $table->dropForeign(['approved_by_id']);
        });
    }
};
