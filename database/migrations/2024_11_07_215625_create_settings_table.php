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
        Schema::create('settings', function (Blueprint $table) {
			$table->increments('id');
            $table->string('school_title');
            $table->string('school_name');
            $table->string('school_address');
            $table->integer('school_phone');
            $table->string('school_email');
            $table->string('school_logo')->nullable();
            $table->string('default_language')->default('ar');
            $table->string('timezone')->default('Africa/Cairo');
            $table->date('academic_year_start');
            $table->date('academic_year_end');
            $table->integer('max_students_per_class')->default(30);
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
        Schema::dropIfExists('settings');
    }
};

