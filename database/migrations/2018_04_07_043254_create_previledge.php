<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePreviledge extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('previledge', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('key')->nullable();
            $table->string('value')->nullable();
            $table->boolean('isCanConfigureBranch')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('previledge');
    }
}
