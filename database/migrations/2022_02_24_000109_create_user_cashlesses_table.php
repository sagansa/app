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
        Schema::create('user_cashlesses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('admin_cashless_id')->nullable();
            $table->unsignedBigInteger('store_id');
            $table->string('email')->nullable();
            $table->string('username', 50)->nullable();
            $table->string('password')->nullable();
            $table->string('no_telp')->nullable();

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
        Schema::dropIfExists('user_cashlesses');
    }
};
