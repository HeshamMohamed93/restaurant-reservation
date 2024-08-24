<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('orders')) {
            Schema::create('orders', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('table_id');
                $table->unsignedBigInteger('reservation_id');
                $table->unsignedBigInteger('customer_id');
                $table->unsignedBigInteger('user_id');
                $table->unsignedDecimal('total', 8, 2);
                $table->boolean('paid');
                $table->dateTime('date');
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }
}
