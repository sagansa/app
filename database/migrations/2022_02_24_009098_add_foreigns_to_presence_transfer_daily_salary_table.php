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
        Schema::table('presence_transfer_daily_salary', function (
            Blueprint $table
        ) {
            $table
                ->foreign('presence_id')
                ->references('id')
                ->on('presences')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('transfer_daily_salary_id')
                ->references('id')
                ->on('transfer_daily_salaries')
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
        Schema::table('presence_transfer_daily_salary', function (
            Blueprint $table
        ) {
            $table->dropForeign(['presence_id']);
            $table->dropForeign(['transfer_daily_salary_id']);
        });
    }
};
