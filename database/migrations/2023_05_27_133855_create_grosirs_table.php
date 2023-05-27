<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateGrosirsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grosirs', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('metal');
            $table->float('carat');
            $table->float('weight1');
            $table->string('pearls');
            $table->string('color');
            $table->string('shape');
            $table->string('grade');
            $table->float('weight2');
            $table->string('size');
            $table->bigInteger('price');
            $table->bigInteger('price_sell');
            $table->bigInteger('price_discount');
            $table->string('barcode');
            $table->integer('discount');
            $table->integer('stok');
            $table->integer('order_id')->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('grosirs');
    }
}
