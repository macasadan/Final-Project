<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateReservationsTableAddReservationDate extends Migration
{
    public function up()
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->timestamp('reservation_date')->nullable()->default(null)->change();
        });
    }

    public function down()
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->timestamp('reservation_date')->nullable(false)->change();
        });
    }
}
