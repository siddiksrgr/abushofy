<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComplainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('complains', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('transaction_detail_id')->constrained();
            $table->string('complain');
            $table->integer('quantity');
            $table->string('photo');
            $table->string('status');
            $table->string('user_resi')->nullable();
            $table->string('store_resi')->nullable();
            $table->dateTimeTz('user_shipping_date')->nullable();
            $table->dateTimeTz('store_shipping_date')->nullable();
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
        Schema::dropIfExists('complains');
    }
}
