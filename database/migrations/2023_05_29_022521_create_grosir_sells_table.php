<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGrosirSellsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grosir_sells', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id');
            $table->integer('grosir_id');
            $table->integer('diskon');
            $table->integer('jumlah');
            $table->integer('total');
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
        Schema::dropIfExists('grosir_sells');
    }
}
