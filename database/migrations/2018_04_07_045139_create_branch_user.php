<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBranchUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branch_user', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->boolean('isActive')->default(false);

            $table->date('dateIn')->nullable();
            $table->date('dateOut')->nullable();

            $table->integer('branch_id')->unsigned()->nullable();
            $table->foreign('branch_id')
                ->references('id')
                ->on('branch')
                ->onDelete('cascade')
                ->onUpdate('cascade');


            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->integer('select_class_id')->unsigned()->nullable();
            $table->foreign('select_class_id')
                ->references('id')
                ->on('select_class')
                ->onDelete('cascade')
                ->onUpdate('cascade');


            $table->integer('select_role_id')->unsigned()->nullable();
            $table->foreign('select_role_id')
                ->references('id')
                ->on('select_role')
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
        Schema::dropIfExists('branch_user');
    }
}
