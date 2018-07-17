<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBranchEvent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branch_event', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->string('youtubeLink')->nullable();
            $table->integer('branch_id')->unsigned()->nullable();


            $table->foreign('branch_id')
                ->on('branch')
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
        Schema::dropIfExists('branch_event');
    }
}
