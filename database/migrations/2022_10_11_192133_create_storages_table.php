<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateStoragesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('storages', function (Blueprint $table) {
            $table->integer('id', true)->comment('Egyedi azonosító');
            $table->string('key')->unique('wed_storages_key_unique')->comment('Kulcs');
            $table->double('value')->comment('Érték');
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent()->comment('Módosítás dátuma');
        });

        DB::table('storages')->insert(
            array(
                [
                    'key' => 'distilled_water',
                    'value' => 0,
                ],
                [
                    'key' => 'pectin_breaker',
                    'value' => 0,
                ],
                [
                    'key' => 'antifoam',
                    'value' => 0,
                ],
                [
                    'key' => 'sugar',
                    'value' => 0,
                ],
                [
                    'key' => 'yeast',
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
        Schema::dropIfExists('storages');
    }
}
