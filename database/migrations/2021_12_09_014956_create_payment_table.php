<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment', function (Blueprint $table) {
            $table->id();
            $table->string('payment_id')->nullable();
            $table->string('cost')->nullable();
            $table->string('bus')->nullable();
            $table->string('name_customer')->nullable();
            $table->string('phone_customer')->nullable();
            $table->string('name')->nullable();
            $table->string('license_plate')->nullable();
            $table->string('roads')->nullable();
            $table->string('start')->nullable();
            $table->string('end')->nullable();
            $table->string('driver')->nullable();
            $table->string('driver_mate')->nullable();
            $table->string('date')->nullable();
            $table->string('total_buy')->nullable();
            $table->string('trips_id')->nullable();
            $table->string('status_payment')->nullable();
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
        Schema::dropIfExists('payment');
    }
}
