<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoadsCloneTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roads_clone', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->integer('garages_id_first')->nullable();
            $table->integer('garages_id_second')->nullable();
            $table->string('station')->nullable();
            $table->integer('users_id')->nullable();
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
        Schema::dropIfExists('roads_clone');
    }
}
