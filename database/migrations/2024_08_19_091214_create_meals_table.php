<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('meals')) {
            Schema::create('meals', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->text('description');
                $table->unsignedDecimal('price', 8, 2);
                $table->integer('available_quantity');
                $table->unsignedDecimal('discount', 5, 2)->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }
}
