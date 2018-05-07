<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('league')->unsigned();
            $table->integer('team1')->unsigned();
            $table->integer('team2')->unsigned();
            $table->integer('winner')->unsigned()->nullable();
            $table->date('date');

            $table->foreign('league')->references('id')->on('leagues');
            $table->foreign('team1')->references('id')->on('gbateams');
            $table->foreign('team2')->references('id')->on('gbateams');
            $table->foreign('winner')->references('id')->on('gbateams');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedules');
    }
}
