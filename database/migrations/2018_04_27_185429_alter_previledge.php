<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPreviledge extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('previledge', function (Blueprint $table) {
            //
            $table->boolean('isCanConfigureBranch')->default(true)->change();
            $table->boolean('allUserProfile')->default(true);
            $table->boolean('pupilProfile')->default(true);
            $table->boolean('pupilScore')->default(true);
            $table->boolean('website')->default(true);
            $table->boolean('addPupil')->default(true);
            $table->boolean('addTeacher')->default(true);
//            $table->boolean('addTeacher')->default(true);



        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('previledge', function (Blueprint $table) {
            //
//            $table->dropColumn();
        });
    }
}
