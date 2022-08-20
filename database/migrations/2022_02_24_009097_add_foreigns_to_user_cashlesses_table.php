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
        Schema::table('user_cashlesses', function (Blueprint $table) {
            $table
                ->foreign('admin_cashless_id')
                ->references('id')
                ->on('admin_cashlesses')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('store_id')
                ->references('id')
                ->on('stores')
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
        Schema::table('user_cashlesses', function (Blueprint $table) {
            $table->dropForeign(['admin_cashless_id']);
            $table->dropForeign(['store_id']);
        });
    }
};
