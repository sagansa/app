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
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('id')->unique();
            $table->string('identity_no');
            $table->string('fullname');
            $table->string('nickname', 20);
            $table->string('no_telp');
            $table->string('birth_place');
            $table->date('birth_date');
            $table->tinyInteger('gender');
            $table->tinyInteger('religion');
            $table->tinyInteger('marital_status');
            $table->tinyInteger('level_of_education');
            $table->string('major');
            $table->string('fathers_name');
            $table->string('mothers_name');
            $table->text('address');
            $table->unsignedBigInteger('province_id')->nullable();
            $table->unsignedBigInteger('regency_id')->nullable();
            $table->unsignedBigInteger('district_id')->nullable();
            $table->unsignedBigInteger('village_id')->nullable();
            $table->integer('codepos');
            $table->string('gps_location')->nullable();
            $table->string('parents_no_telp');
            $table->string('siblings_name');
            $table->string('siblings_no_telp');
            $table->boolean('bpjs');
            $table->string('driver_license');
            $table->unsignedBigInteger('bank_id');
            $table->string('bank_account_no');
            $table->date('accepted_work_date');
            $table->string('ttd');
            $table->text('notes');
            $table->string('image_identity_id');
            $table->string('image_selfie');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('employee_status_id')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
};
