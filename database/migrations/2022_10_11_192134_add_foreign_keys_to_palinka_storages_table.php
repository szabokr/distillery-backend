<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToPalinkaStoragesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('palinka_storages', function (Blueprint $table) {
            $table->foreign(['fruit_id'], 'palinka_storages_ibfk_2')->references(['id'])->on('fruits');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('palinka_storages', function (Blueprint $table) {
            $table->dropForeign('palinka_storages_ibfk_2');
        });
    }
}
