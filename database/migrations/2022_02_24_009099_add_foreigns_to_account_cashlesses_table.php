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
        Schema::table('account_cashlesses', function (Blueprint $table) {
            $table
                ->foreign('cashless_provider_id')
                ->references('id')
                ->on('cashless_providers')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('store_id')
                ->references('id')
                ->on('stores')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('store_cashless_id')
                ->references('id')
                ->on('store_cashlesses')
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
        Schema::table('account_cashlesses', function (Blueprint $table) {
            $table->dropForeign(['cashless_provider_id']);
            $table->dropForeign(['store_id']);
            $table->dropForeign(['store_cashless_id']);
        });
    }
};
