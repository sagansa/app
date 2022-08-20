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
        Schema::table('utilities', function (Blueprint $table) {
            $table
                ->foreign('store_id')
                ->references('id')
                ->on('stores')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('unit_id')
                ->references('id')
                ->on('units')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('utility_provider_id')
                ->references('id')
                ->on('utility_providers')
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
        Schema::table('utilities', function (Blueprint $table) {
            $table->dropForeign(['store_id']);
            $table->dropForeign(['unit_id']);
            $table->dropForeign(['utility_provider_id']);
        });
    }
};
