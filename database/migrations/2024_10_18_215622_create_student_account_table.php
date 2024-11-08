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
		Schema::create('student_account', function(Blueprint $table) {
			$table->increments('id');
			$table->boolean('type')->default(1);
            $table->integer('student_id')->unsigned();
            $table->integer('invoice_id')->unsigned()->nullable();
            $table->integer('receipt_id')->unsigned()->nullable();
            $table->integer('payment_id')->unsigned()->nullable();
            $table->integer('refund_id')->unsigned()->nullable();
            $table->decimal('debit')->nullable();
            $table->decimal('credit')->nullable();
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
        Schema::dropIfExists('student_account');
    }
};

