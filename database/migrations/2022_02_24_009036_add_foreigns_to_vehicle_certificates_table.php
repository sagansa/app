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
        Schema::table('vehicle_certificates', function (Blueprint $table) {
            $table
                ->foreign('vehicle_id')
                ->references('id')
                ->on('vehicles')
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
        Schema::table('vehicle_certificates', function (Blueprint $table) {
            $table->dropForeign(['vehicle_id']);
        });
    }
};
