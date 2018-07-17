<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAbsenceBranch extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absence_branch', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->boolean('isDone')->nullable();
            $table->integer('totalPupil')->default(0);
            $table->integer('totalAbsence')->default(0);


            $table->integer('select_class_id')->unsigned()->nullable();
            $table->foreign('select_class_id')
                ->on('select_class')
                ->references('id')
                ->onDelete('cascade')
                ->onUpdate('cascade');


            $table->integer('branch_id')->unsigned()->nullable();
            $table->foreign('branch_id')
                ->on('branch')
                ->references('id')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->integer('absence_date_id')->unsigned()->nullable();
            $table->foreign('absence_date_id')
                ->on('absence_date')
                ->references('id')
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
        Schema::dropIfExists('absence_branch');
    }
}
