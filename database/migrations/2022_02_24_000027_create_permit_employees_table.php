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
        Schema::create('permit_employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->tinyInteger('reason');
            $table->date('from_date');
            $table->date('until_date');
            $table->tinyInteger('status');
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by_id')->nullable();
            $table->unsignedBigInteger('approved_by_id')->nullable();

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
        Schema::dropIfExists('permit_employees');
    }
};
