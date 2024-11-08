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
		Schema::create('invoices', function(Blueprint $table) {
			$table->increments('id');
            $table->date('date');
            $table->integer('stage_id')->unsigned();
            $table->integer('grade_id')->unsigned();
            $table->integer('student_id')->unsigned();
            $table->integer('fee_id')->unsigned();
            $table->decimal('amount');
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
        Schema::dropIfExists('invoices');
    }
};

