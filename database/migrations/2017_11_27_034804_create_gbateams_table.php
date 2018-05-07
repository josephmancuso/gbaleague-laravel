<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGbateamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gbateams', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('league')->unsigned()->nullable();
            $table->foreign('league')->references('id')->on('leagues');
            $table->integer('owner')->unsigned();
            $table->integer('points')->default(1000);
            $table->string('picture')->nullable()->length(255);
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
        Schema::dropIfExists('gbateams');
    }
}
