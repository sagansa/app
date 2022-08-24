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
        Schema::create('admin_cashless_user_cashless', function (
            Blueprint $table
        ) {
            $table->unsignedBigInteger('admin_cashless_id');
            $table->unsignedBigInteger('user_cashless_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_cashless_user_cashless');
    }
};
