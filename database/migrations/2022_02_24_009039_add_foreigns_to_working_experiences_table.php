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
        Schema::table('working_experiences', function (Blueprint $table) {
            $table
                ->foreign('employee_id')
                ->references('id')
                ->on('employees')
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
        Schema::table('working_experiences', function (Blueprint $table) {
            $table->dropForeign(['employee_id']);
        });
    }
};
