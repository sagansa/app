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
        Schema::table('sales_order_onlines', function (Blueprint $table) {
            $table
                ->foreign('store_id')
                ->references('id')
                ->on('stores')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('online_shop_provider_id')
                ->references('id')
                ->on('online_shop_providers')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('customer_id')
                ->references('id')
                ->on('customers')
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
        Schema::table('sales_order_onlines', function (Blueprint $table) {
            $table->dropForeign(['store_id']);
            $table->dropForeign(['online_shop_provider_id']);
            $table->dropForeign(['customer_id']);
            $table->dropForeign(['created_by_id']);
            $table->dropForeign(['approved_by_id']);
        });
    }
};
