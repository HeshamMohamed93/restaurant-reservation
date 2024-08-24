<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('reservations')) {
            Schema::create('reservations', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('table_id');
                $table->unsignedBigInteger('customer_id');
                $table->dateTime('from_time');
                $table->dateTime('to_time');
                $table->timestamps();
                $table->softDeletes();
            });
        }

    }
}
