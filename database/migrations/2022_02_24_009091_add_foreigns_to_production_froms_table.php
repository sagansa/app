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
        Schema::table('production_froms', function (Blueprint $table) {
            $table
                ->foreign('purchase_order_product_id')
                ->references('id')
                ->on('purchase_order_products')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('production_id')
                ->references('id')
                ->on('productions')
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
        Schema::table('production_froms', function (Blueprint $table) {
            $table->dropForeign(['purchase_order_product_id']);
            $table->dropForeign(['production_id']);
        });
    }
};
