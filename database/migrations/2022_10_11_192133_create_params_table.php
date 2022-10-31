<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateParamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('params', function (Blueprint $table) {
            $table->integer('id', true)->comment('Egyedi azonosító');
            $table->string('key')->unique()->comment('Kulcs');
            $table->integer('value')->comment('Érték');
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent()->comment('Módosítás dátuma');
        });

        DB::table('params')->insert(
            array(
                [
                    'key' => 'cooking_price',
                    'value' => 0,
                ],
                [
                    'key' => 'sugar_price',
                    'value' => 0,
                ],
                [
                    'key' => 'distilled_water_price',
                    'value' => 0,
                ],
                [
                    'key' => 'pectinbreaker_price',
                    'value' => 0,
                ],
                [
                    'key' => 'antifoam_price',
                    'value' => 0,
                ],
                [
                    'key' => 'gas_price',
                    'value' => 0,
                ],
                [
                    'key' => 'electricity_price',
                    'value' => 0,
                ],
                [
                    'key' => 'yeast_price',
                    'value' => 0,
                ],
                [
                    'key' => 'used_gas',
                    'value' => 0,
                ],
                [
                    'key' => 'used_electricity',
                    'value' => 0,
                ],
                [
                    'key' => 'capacity',
                    'value' => 0,
                ],
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('params');
    }
}
