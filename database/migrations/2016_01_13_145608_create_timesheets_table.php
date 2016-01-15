<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimesheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timesheets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('lundi',20);
            $table->string('mardi',20);
            $table->string('mercredi',20);
            $table->string('jeudi',20);
            $table->string('vendredi',20);
            $table->string('samedi',20);
            $table->time('time');
            $table->string('matiere',50);
            $table->integer('user_id')->unsigned();
            $table->integer('classroom_id')->unsigned();
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
          Schema::drop('timesheets');
    }
}
