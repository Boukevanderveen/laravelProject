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
        Schema::create('order_adresses', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('company_name')->nullable();
            $table->string('name');
            $table->string('street');
            $table->integer('house_number');
            $table->string('addition')->nullable();
            $table->string('city');
            $table->string('zipcode');
            $table->string('phone_number')->nullable();
            $table->string('email');
            $table->unsignedBigInteger('order_id')->nullable();
            $table->foreign('order_id')->references('id')->on('orders');
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
        Schema::dropIfExists('order_adresses');
    }
};
