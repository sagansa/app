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
        Schema::create('contract_locations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('store_id');
            $table->string('file')->nullable();
            $table->string('address');
            $table->unsignedBigInteger('province_id')->nullable();
            $table->unsignedBigInteger('regency_id')->nullable();
            $table->unsignedBigInteger('district_id')->nullable();
            $table->unsignedBigInteger('village_id')->nullable();
            $table->integer('codepos')->nullable();
            $table->string('gps_location')->nullable();
            $table->date('from_date');
            $table->date('until_date');
            $table->string('contact_person');
            $table->string('no_contact_person');
            $table->bigInteger('nominal_contract_per_year');

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
        Schema::dropIfExists('contract_locations');
    }
};
