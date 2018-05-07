<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDraftedpokemonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('draftedpokemon', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('team')->unsigned();
            $table->integer('pokemon')->unsigned();
            $table->integer('queue')->unsigned()->nullable();
            $table->integer('league')->unsigned();

            $table->foreign('team')->references('id')->on('gbateams');
            $table->foreign('pokemon')->references('id')->on('pokemon');
            $table->foreign('queue')->references('id')->on('pokemon');
            $table->foreign('league')->references('id')->on('leagues');
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
        Schema::dropIfExists('draftedpokemon');
    }
}
