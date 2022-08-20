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
        Schema::create('presence_transfer_daily_salary', function (
            Blueprint $table
        ) {
            $table->unsignedBigInteger('presence_id');
            $table->unsignedBigInteger('transfer_daily_salary_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('presence_transfer_daily_salary');
    }
};
