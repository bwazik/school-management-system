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
		Schema::create('promotions', function(Blueprint $table) {
			$table->increments('id');
            $table->integer('student_id')->unsigned();
            $table->integer('from_stage')->unsigned();
            $table->integer('from_grade')->unsigned();
            $table->integer('from_classroom')->unsigned();
            $table->integer('from_academic_year');
            $table->integer('to_stage')->unsigned();
            $table->integer('to_grade')->unsigned();
            $table->integer('to_classroom')->unsigned();
            $table->integer('to_academic_year');
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
        Schema::dropIfExists('promotions');
    }
};

