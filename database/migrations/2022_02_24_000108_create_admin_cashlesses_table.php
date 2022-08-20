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
        Schema::create('admin_cashlesses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('cashless_provider_id');
            $table->string('username', 50)->nullable();
            $table->string('email')->nullable();
            $table->string('no_telp')->nullable();
            $table->string('password')->nullable();

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
        Schema::dropIfExists('admin_cashlesses');
    }
};
