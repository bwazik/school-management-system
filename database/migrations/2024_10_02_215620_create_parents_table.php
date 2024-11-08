<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('parents', function(Blueprint $table) {
			$table->increments('id');
            $table->string('email')->unique();
            $table->string('password');

            # Father
            $table->string('father_name');
            $table->string('father_national_id');
            $table->string('father_passport_id');
            $table->string('father_phone');
            $table->string('father_job');
            $table->integer('father_nationality')->unsigned();
            $table->integer('father_blood_type')->unsigned();
            $table->integer('father_religion')->unsigned();
            $table->string('father_address');

            # Mother
            $table->string('mother_name');
            $table->string('mother_national_id');
            $table->string('mother_passport_id');
            $table->string('mother_phone');
            $table->string('mother_job');
            $table->integer('mother_nationality')->unsigned();
            $table->integer('mother_blood_type')->unsigned();
            $table->integer('mother_religion')->unsigned();
            $table->string('mother_address');

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
        Schema::dropIfExists('parents');
    }
};

