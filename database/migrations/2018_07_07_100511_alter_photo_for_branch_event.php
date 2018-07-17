<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPhotoForBranchEvent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('photo', function (Blueprint $table) {
            //


            $table->string('youtubeLink')->nullable();
            $table->integer('type')->default(1);
            $table->integer('branch_event_id')->unsigned()->nullable();
            $table->foreign('branch_event_id')
                ->on('branch_event')
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
        Schema::table('photo', function (Blueprint $table) {
            //

            $table->dropForeign(["branch_event_id"]);
            $table->dropColumn("branch_event_id");
            $table->dropColumn("youtubeLink");
            $table->dropColumn("type");


        });
    }
}
