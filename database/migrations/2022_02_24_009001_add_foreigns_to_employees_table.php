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
        Schema::table('employees', function (Blueprint $table) {
            $table
                ->foreign('province_id')
                ->references('id')
                ->on('provinces')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('regency_id')
                ->references('id')
                ->on('regencies')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('district_id')
                ->references('id')
                ->on('districts')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('village_id')
                ->references('id')
                ->on('villages')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('bank_id')
                ->references('id')
                ->on('banks')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('employee_status_id')
                ->references('id')
                ->on('employee_statuses')
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
        Schema::table('employees', function (Blueprint $table) {
            $table->dropForeign(['province_id']);
            $table->dropForeign(['regency_id']);
            $table->dropForeign(['district_id']);
            $table->dropForeign(['village_id']);
            $table->dropForeign(['bank_id']);
            $table->dropForeign(['user_id']);
            $table->dropForeign(['employee_status_id']);
        });
    }
};
