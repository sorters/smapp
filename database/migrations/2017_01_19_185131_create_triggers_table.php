<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTriggersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('triggers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('threshold');
            $table->integer('offset');
            $table->boolean('fill');
            $table->boolean('enabled');
            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('products');
            $table->integer('product_offer_id')->unsigned();
            $table->foreign('product_offer_id')->references('id')->on('productoffers');
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
        Schema::drop('triggers');
    }
}
