<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUserAbsenceRecord2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_absence_record', function (Blueprint $table) {
            //

            $table->boolean("isFollowedUp")->default(false)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_absence_record', function (Blueprint $table) {
            //

            $table->dropColumn("isFollowedUp");
        });
    }
}
