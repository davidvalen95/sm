<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAbsenceBranchAdd extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('absence_branch', function (Blueprint $table) {
            //

            $table->integer('user_commiter_id')->unsigned()->nullable();

            $table->foreign('user_commiter_id')
                ->on('users')
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
        Schema::table('absence_branch', function (Blueprint $table) {
            //

            $table->dropForeign(['user_commiter_id']);
            $table->dropColumn('user_commiter_id');
        });
    }
}
