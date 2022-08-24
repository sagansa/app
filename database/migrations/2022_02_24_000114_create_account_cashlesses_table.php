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
        Schema::create('account_cashlesses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('cashless_provider_id');
            $table->unsignedBigInteger('store_id');
            $table->unsignedBigInteger('store_cashless_id');
            $table->string('email')->nullable();
            $table->string('username')->nullable();
            $table->string('password')->nullable();
            $table->string('no_telp')->nullable();
            $table->tinyInteger('status');
            $table->text('notes')->nullable();

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
        Schema::dropIfExists('account_cashlesses');
    }
};
