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
		Schema::create('online_classes', function(Blueprint $table) {
			$table->increments('id');
            $table->boolean('integration');
            $table->integer('stage_id')->unsigned();
            $table->integer('grade_id')->unsigned();
            $table->integer('classroom_id')->unsigned();
            $table->integer('teacher_id')->unsigned();
            $table->string('meeting_id');
            $table->string('topic');
            $table->integer('duration');
            $table->string('password');
            $table->dateTime('start_time');
            $table->text('start_url');
            $table->text('join_url');
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
        Schema::dropIfExists('online_classes');
    }
};

