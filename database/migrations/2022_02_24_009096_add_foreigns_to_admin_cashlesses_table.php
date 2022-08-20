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
        Schema::table('admin_cashlesses', function (Blueprint $table) {
            $table
                ->foreign('cashless_provider_id')
                ->references('id')
                ->on('cashless_providers')
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
        Schema::table('admin_cashlesses', function (Blueprint $table) {
            $table->dropForeign(['cashless_provider_id']);
        });
    }
};
