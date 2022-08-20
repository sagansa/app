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
        Schema::table('products', function (Blueprint $table) {
            $table
                ->foreign('unit_id')
                ->references('id')
                ->on('units')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('material_group_id')
                ->references('id')
                ->on('material_groups')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('franchise_group_id')
                ->references('id')
                ->on('franchise_groups')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('payment_type_id')
                ->references('id')
                ->on('payment_types')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('online_category_id')
                ->references('id')
                ->on('online_categories')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('product_group_id')
                ->references('id')
                ->on('product_groups')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('restaurant_category_id')
                ->references('id')
                ->on('restaurant_categories')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('user_id')
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
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['unit_id']);
            $table->dropForeign(['material_group_id']);
            $table->dropForeign(['franchise_group_id']);
            $table->dropForeign(['payment_type_id']);
            $table->dropForeign(['online_category_id']);
            $table->dropForeign(['product_group_id']);
            $table->dropForeign(['restaurant_category_id']);
            $table->dropForeign(['user_id']);
        });
    }
};
