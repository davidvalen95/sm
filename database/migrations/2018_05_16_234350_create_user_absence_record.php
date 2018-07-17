<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAbsenceRecord extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_absence_record', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();


            $table->text('reason')->nullable();




            $table->integer('branch_user_id')->unsigned()->nullable();
            $table->foreign('branch_user_id')
                ->on('branch_user')
                ->references('id')
                ->onDelete('cascade')
                ->onUpdate('cascade');



            $table->integer('absence_branch_id')->unsigned()->nullable();
            $table->foreign('absence_branch_id')
                ->on('absence_branch')
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
        Schema::dropIfExists('user_absence_record');
    }
}
