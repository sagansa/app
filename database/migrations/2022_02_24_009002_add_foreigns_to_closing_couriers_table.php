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
        Schema::table('closing_couriers', function (Blueprint $table) {
            $table
                ->foreign('bank_id')
                ->references('id')
                ->on('banks')
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
        Schema::table('closing_couriers', function (Blueprint $table) {
            $table->dropForeign(['bank_id']);
            $table->dropForeign(['created_by_id']);
            $table->dropForeign(['approved_by_id']);
        });
    }
};
