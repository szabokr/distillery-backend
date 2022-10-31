<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCorrectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('corrections', function (Blueprint $table) {
            $table->integer('temperature')->comment('Hőmérséklet(°C)');
            $table->double('correction')->comment('Korrekció(%)');
        });

        DB::table('corrections')->insert(
            array(
                [
                    'temperature' => 30,
                    'correction' => -3.8,
                ],
                [
                    'temperature' => 29,
                    'correction' => -3.4,
                ],
                [
                    'temperature' => 28,
                    'correction' => -3.0,
                ],
                [
                    'temperature' => 27,
                    'correction' => -2.6,
                ],
                [
                    'temperature' => 26,
                    'correction' => -2.3,
                ],
                [
                    'temperature' => 25,
                    'correction' => -1.9,
                ],
                [
                    'temperature' => 24,
                    'correction' => -1.5,
                ],
                [
                    'temperature' => 23,
                    'correction' => -1.1,
                ],
                [
                    'temperature' => 22,
                    'correction' => -0.7,
                ],
                [
                    'temperature' => 21,
                    'correction' => -0.3,
                ],
                [
                    'temperature' => 20,
                    'correction' => 0,
                ],
                [
                    'temperature' => 19,
                    'correction' => 0.3,
                ],
                [
                    'temperature' => 18,
                    'correction' => 0.7,
                ],
                [
                    'temperature' => 17,
                    'correction' => 1.1,
                ],
                [
                    'temperature' => 16,
                    'correction' => 1.5,
                ],
                [
                    'temperature' => 15,
                    'correction' => 1.8,
                ],
                [
                    'temperature' => 14,
                    'correction' => 2.2,
                ],
                [
                    'temperature' => 13,
                    'correction' => 2.5,
                ],
                [
                    'temperature' => 12,
                    'correction' => 2.9,
                ],
                [
                    'temperature' => 11,
                    'correction' => 3.3,
                ],
                [
                    'temperature' => 10,
                    'correction' => 3.7,
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
        Schema::dropIfExists('corrections');
    }
}
