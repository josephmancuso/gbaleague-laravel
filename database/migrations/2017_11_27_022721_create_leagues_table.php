<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeaguesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leagues', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('owner')->unsigned();
            $table->foreign('owner')->references('id')->on('users');
            $table->text('overview')->nullable();
            $table->string('slug');
            $table->integer('tournament');
            $table->integer('current')->unsigned();
            $table->foreign('current')->references('id')->on('users');
            $table->integer('status')->nullable()->unsigned();
            $table->integer('ordering')->nullable();
            $table->string('draftorder');
            $table->integer('round')->default('1');

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
        Schema::dropIfExists('leagues');
    }
}
