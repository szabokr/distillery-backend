<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCookingForHiresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cooking_for_hires', function (Blueprint $table) {
            $table->integer('id', true)->comment('Egyedi azonosító');
            $table->integer('fruit_id')->index('fruit_id')->comment('Gyümölcs egyedi azonosítója');
            $table->integer('mash')->comment('Cefre(l)');
            $table->double('vodka')->comment('Vodka(l)');
            $table->integer('number_of_cooking')->comment('Főzések száma');
            $table->double('unadjusted_palinka')->comment('Nem állított pálinka(l)');
            $table->double('finished_palinka')->comment('Kész pálinka(l)');
            $table->integer('alcohol_degree')->default(48)->comment('Alcoholfok(%)');
            $table->integer('original_alcohol_degree')->comment('Eredeti alcoholfok(%)');
            $table->integer('temperature')->comment('Hőmérséklet(°C)');
            $table->integer('income')->comment('Bevétel');
            $table->integer('expenditure')->comment('Kiadás');
            $table->tinyInteger('own')->default(0)->comment('Saját főzés');
            $table->integer('mash_storage_id')->nullable()->index('mash_storage_id')->comment('Cefre raktár egyedi azonosítója');
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
        Schema::dropIfExists('cooking_for_hires');
    }
}
