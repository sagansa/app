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
        Schema::table('utility_usages', function (Blueprint $table) {
            $table
                ->foreign('utility_id')
                ->references('id')
                ->on('utilities')
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
        Schema::table('utility_usages', function (Blueprint $table) {
            $table->dropForeign(['utility_id']);
            $table->dropForeign(['created_by_id']);
            $table->dropForeign(['approved_by_id']);
        });
    }
};
