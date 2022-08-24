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
        Schema::create('account_cashless_admin_cashless', function (
            Blueprint $table
        ) {
            $table->unsignedBigInteger('account_cashless_id');
            $table->unsignedBigInteger('admin_cashless_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account_cashless_admin_cashless');
    }
};
