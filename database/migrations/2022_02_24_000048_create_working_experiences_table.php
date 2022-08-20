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
        Schema::create('working_experiences', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->string('place');
            $table->string('position');
            $table->string('salary_per_month');
            $table->string('previous_boss_name')->nullable();
            $table->string('previous_boss_no')->nullable();
            $table->date('from_date');
            $table->date('until_date');
            $table->text('reason');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('working_experiences');
    }
};
