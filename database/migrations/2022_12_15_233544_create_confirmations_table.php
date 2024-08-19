<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfirmationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('confirmations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->constrained();
            $table->string('down_payment')->nullable();
            $table->string('paid_off')->nullable();
            $table->string('status');
            $table->dateTimeTz('down_payment_date')->nullable();
            $table->dateTimeTz('paid_off_date')->nullable();
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
        Schema::dropIfExists('confirmations');
    }
}
