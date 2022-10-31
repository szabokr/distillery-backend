<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoldProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sold_products', function (Blueprint $table) {
            $table->integer('id', true)->comment('Egyedi azonosító');
            $table->integer('fruit_id')->index('fruit_id')->comment('Gyümölcs egyedi azonosítója');
            $table->double('quantity')->comment('Mennyiség(l)');
            $table->integer('price')->comment('Ár');
            $table->integer('expenditure')->comment('Kiadás');
            $table->date('date')->comment('Eladás dátuma');
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
        Schema::dropIfExists('sold_products');
    }
}
