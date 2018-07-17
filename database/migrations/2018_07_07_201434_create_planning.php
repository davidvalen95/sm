<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanning extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('planning', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();


            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->date('dueDate')->nullable();

            $table->integer('branch_id')->unsigned()->nullable();
            $table->foreign('branch_id')
                ->on('branch')
                ->references('id')
                ->onUpdate('cascade')
                ->onDelete('cascade');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('planning');
    }
}
