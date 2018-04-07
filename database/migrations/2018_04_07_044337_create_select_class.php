<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSelectClass extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('select_class', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('key')->nullable();
            $table->string('value')->nullable();
        });

        Schema::create('select_event', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('key')->nullable();
            $table->string('value')->nullable();
        });

        Schema::create('select_role', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('key')->nullable();
            $table->string('value')->nullable();
        });

        Schema::create('select_week_date', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('key')->nullable();
            $table->string('value')->nullable();
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('select_class');
        Schema::dropIfExists('select_event');
        Schema::dropIfExists('select_role');
        Schema::dropIfExists('select_week_date');
    }
}
