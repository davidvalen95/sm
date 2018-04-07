<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();

            $table->string('nbg')->nullable();
            $table->date('birthDate')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();

            $table->integer('previledge_id')->unsigned()->nullable();
            $table->foreign('previledge_id')
                ->references('id')
                ->on('previledge')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->integer('photo_id')->unsigned()->nullable();
            $table->foreign('photo_id')
                ->references('id')
                ->on('photo')
                ->onDelete('cascade')
                ->onUpdate('cascade');


        });
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
