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
        Schema::table('movement_asset_audits', function (Blueprint $table) {
            $table
                ->foreign('movement_asset_id')
                ->references('id')
                ->on('movement_assets')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('movement_asset_result_id')
                ->references('id')
                ->on('movement_asset_results')
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
        Schema::table('movement_asset_audits', function (Blueprint $table) {
            $table->dropForeign(['movement_asset_id']);
            $table->dropForeign(['movement_asset_result_id']);
        });
    }
};
