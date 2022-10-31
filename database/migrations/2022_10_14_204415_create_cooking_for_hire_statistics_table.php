<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCookingForHireStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cooking_for_hire_statistics', function (Blueprint $table) {
            $table->integer('id', true)->comment('Egyedi azonosító');
            $table->integer('own')->comment('Saját főzés');
            $table->date('date')->comment('Dátum');
            $table->integer('mash')->comment('Cefre(l)');
            $table->double('vodka')->comment('Vodka(l)');
            $table->integer('number_of_cooking')->comment('Főzések száma');
            $table->double('unadjusted_palinka')->comment('Nem beállított pálinka(l)');
            $table->double('finished_palinka')->comment('Beállított pálinka(l)');
            $table->integer('income')->comment('Bevéltel');
            $table->integer('used_gas')->comment('Elhasznált gáz');
            $table->integer('used_gas_price')->comment('Elhasznált gáz ára');
            $table->integer('used_electricity')->comment('Elhasznált áram');
            $table->integer('used_electricity_price')->comment('Elhasznált áram ára');
            $table->double('used_distilled_water')->comment('Elhasznált desztilált víz');
            $table->integer('used_distilled_water_price')->comment('Elhasznált desztilált víz');
            $table->double('used_antifoam')->comment('Elhasznált habzásgátló');
            $table->integer('used_antifoam_price')->comment('Elhasznált habzásgátló ára');
            $table->integer('fruit_price')->default(0)->comment('Gyümölcs ára');
            $table->integer('sugar')->default(0)->comment('Elhasznált cukor');
            $table->integer('sugar_price')->default(0)->comment('Elhasznált cukor ára');
            $table->integer('pectin_breaker')->default(0)->comment('Elhasznált pektinbontó');
            $table->integer('pectin_breaker_price')->default(0)->comment('Elhasznált pektinbontó ára');
            $table->integer('yeast')->default(0)->comment('Elhasznált élesztő');
            $table->integer('yeast_price')->default(0)->comment('Elhasznált élesztő ára');
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
        Schema::dropIfExists('cooking_for_hire_statistics');
    }
}
