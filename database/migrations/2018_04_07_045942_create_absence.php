<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAbsence extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absence', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();


            $table->text('reason')->nullable();




            $table->integer('branch_user_id')->unsigned()->nullable();
            $table->foreign('branch_user_id')
                ->references('id')
                ->on('branch_user')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->integer('select_week_date_id')->unsigned()->nullable();
            $table->foreign('select_week_date_id')
                ->references('id')
                ->on('select_week_date')
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
        Schema::dropIfExists('absence');
    }
}
