<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMashStoragesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mash_storages', function (Blueprint $table) {
            $table->integer('id', true)->comment('Egyedi azonosító');
            $table->integer('fruit_id')->index('fruit_id')->comment('Gyümölcs egyedi azonosítója');
            $table->integer('fruit_price')->comment('Gyümölcs ára');
            $table->integer('mash')->comment('Cefre mennyisége');
            $table->integer('sugar')->comment('Cukor(kg)');
            $table->integer('pectin_breaker')->comment('Pektimbontó(db)');
            $table->integer('water')->default(0)->comment('Víz(l)');
            $table->integer('yeast')->comment('Élesztő(db)');
            $table->tinyInteger('cooked')->default(0)->comment('Kifőzve?');
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
        Schema::dropIfExists('mash_storages');
    }
}
