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
        Schema::create('contract_employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('file')->nullable();
            $table->date('from_date');
            $table->date('until_date');
            $table->bigInteger('nominal_guarantee');
            $table->tinyInteger('guarantee');
            $table->unsignedBigInteger('employee_id')->nullable();

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
        Schema::dropIfExists('contract_employees');
    }
};
