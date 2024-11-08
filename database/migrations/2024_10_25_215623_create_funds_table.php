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
		Schema::create('funds', function(Blueprint $table) {
			$table->increments('id');
            $table->date('date');
            $table->integer('receipt_id')->unsigned()->nullable();
            $table->integer('payment_id')->unsigned()->nullable();
            $table->decimal('debit')->nullable();
            $table->decimal('credit')->nullable();
            $table->string('description')->nullable();
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
        Schema::dropIfExists('funds');
    }
};

