<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->integer('id', true)->comment('Egyedi azonosító');
            $table->string('name', 120)->comment('Név');
            $table->string('email', 320)->unique()->comment('Email');
            $table->string('password')->nullable()->comment('Jelszó');
            $table->string('activation_key', 40)->nullable()->comment('Aktiváló kulcs');
            $table->tinyInteger('status')->default(0)->comment('Státusz');
            $table->timestamps();
        });

        DB::table('users')->insert(
            array(
                [
                    'name' => 'SuperAdmin',
                    'email' => 'superadmin@gmail.com',
                    'password' => '$2y$10$onX8OeU6.HKqVG7iuRKReuYlNMY9OEgzPs/n0fMrbaDMnvH44O3Mu',
                    'status' => 1,
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
        Schema::dropIfExists('users');
    }
}
