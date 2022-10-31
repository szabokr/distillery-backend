<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToCookingForHiresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cooking_for_hires', function (Blueprint $table) {
            $table->foreign(['fruit_id'], 'cooking_for_hires_ibfk_3')->references(['id'])->on('fruits');
            $table->foreign(['mash_storage_id'], 'cooking_for_hires_ibfk_4')->references(['id'])->on('mash_storages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cooking_for_hires', function (Blueprint $table) {
            $table->dropForeign('cooking_for_hires_ibfk_3');
            $table->dropForeign('cooking_for_hires_ibfk_4');
        });
    }
}
