<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoldProductStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sold_product_statistics', function (Blueprint $table) {
            $table->integer('id', true)->comment('Egyedi azonosító');
            $table->integer('fruit_id')->index('fruit_id')->comment('Gyümölcs egyedi azonosítója');
            $table->integer('quantity')->comment('Mennyiség(l)');
            $table->integer('income')->comment('Bevétel');
            $table->integer('expenditure')->comment('Kiadás');
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
        Schema::dropIfExists('sold_product_statistics');
    }
}
