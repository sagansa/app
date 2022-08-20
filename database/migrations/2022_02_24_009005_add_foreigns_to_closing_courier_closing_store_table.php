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
        Schema::table('closing_courier_closing_store', function (
            Blueprint $table
        ) {
            $table
                ->foreign('closing_store_id')
                ->references('id')
                ->on('closing_stores')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('closing_courier_id')
                ->references('id')
                ->on('closing_couriers')
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
        Schema::table('closing_courier_closing_store', function (
            Blueprint $table
        ) {
            $table->dropForeign(['closing_store_id']);
            $table->dropForeign(['closing_courier_id']);
        });
    }
};
