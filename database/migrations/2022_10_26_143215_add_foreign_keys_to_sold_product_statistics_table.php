<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToSoldProductStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sold_product_statistics', function (Blueprint $table) {
            $table->foreign(['fruit_id'], 'sold_product_statistics_ibfk_1')->references(['id'])->on('fruits');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sold_product_statistics', function (Blueprint $table) {
            $table->dropForeign('sold_product_statistics_ibfk_1');
        });
    }
}
