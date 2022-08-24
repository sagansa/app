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
        Schema::table('account_cashless_admin_cashless', function (
            Blueprint $table
        ) {
            $table
                ->foreign('account_cashless_id')
                ->references('id')
                ->on('account_cashlesses')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('admin_cashless_id')
                ->references('id')
                ->on('admin_cashlesses')
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
        Schema::table('account_cashless_admin_cashless', function (
            Blueprint $table
        ) {
            $table->dropForeign(['account_cashless_id']);
            $table->dropForeign(['admin_cashless_id']);
        });
    }
};
