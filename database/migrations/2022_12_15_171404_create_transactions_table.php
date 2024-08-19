<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id(); 
            $table->string('code');
            $table->foreignId('user_id')->constrained();
            $table->integer('shipping_price');
            $table->integer('total_price');
            $table->string('transaction_status');
            $table->string('payment_status');
            $table->string('shipping_status');
            $table->string('resi')->nullable();
            $table->string('courier');
            $table->longtext('address');
            $table->string('province');
            $table->string('city');
            $table->string('zip_code');
            $table->string('description');
            $table->dateTime('expired_at')->nullable();
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
        Schema::dropIfExists('transactions');
    }
}
