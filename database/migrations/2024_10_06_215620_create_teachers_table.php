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
		Schema::create('teachers', function(Blueprint $table) {
			$table->increments('id');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('name');
            $table->integer('subject_id')->unsigned();
            $table->integer('gender_id')->unsigned();
            $table->date('joining_date');
            $table->string('address');
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
        Schema::dropIfExists('teachers');
    }
};

