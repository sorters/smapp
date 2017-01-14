<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalelinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salelines', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('state')->default(true);
            $table->double('unit_price');
            $table->integer('units');
            $table->integer('sale_order_id')->unsigned()->nullable();
            $table->foreign('sale_order_id')->references('id')->on('saleorders');
            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('products');
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
        Schema::drop('salelines');
    }
}
