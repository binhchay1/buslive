<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropDateFromToStationFromStationToTimeGoCodeBusIdSeatToTicketTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ticket', function (Blueprint $table) {
            $table->dropColumn('date');
            $table->dropColumn('from');
            $table->dropColumn('to');
            $table->dropColumn('station_from');
            $table->dropColumn('station_to');
            $table->dropColumn('time_go');
            $table->dropColumn('code');
            $table->dropColumn('bus_id');
            $table->dropColumn('seat');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ticket', function (Blueprint $table) {
            //
        });
    }
}
