<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nom_teacher');
            $table->date('date_naissance');
            $table->string('poste');
            $table->string('sexe');
            $table->string('email');
            $table->string('num_fix');
            $table->string('num_portable');
            $table->text('adresse');
            $table->string('cin');
            $table->double('salaire');
            $table->integer('user_id')->unsigned();
            $table->softDeletes();
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
        Schema::drop('teachers');
    }
}
