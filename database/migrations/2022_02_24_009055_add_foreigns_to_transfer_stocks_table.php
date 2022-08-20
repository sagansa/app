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
        Schema::table('transfer_stocks', function (Blueprint $table) {
            $table
                ->foreign('from_store_id')
                ->references('id')
                ->on('stores')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('to_store_id')
                ->references('id')
                ->on('stores')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('approved_by_id')
                ->references('id')
                ->on('users')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('received_by_id')
                ->references('id')
                ->on('users')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('sent_by_id')
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
        Schema::table('transfer_stocks', function (Blueprint $table) {
            $table->dropForeign(['from_store_id']);
            $table->dropForeign(['to_store_id']);
            $table->dropForeign(['approved_by_id']);
            $table->dropForeign(['received_by_id']);
            $table->dropForeign(['sent_by_id']);
        });
    }
};
