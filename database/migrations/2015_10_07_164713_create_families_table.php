<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFamiliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('families', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nom_pere');
            $table->string('nom_mere');
            $table->string('email_responsable');
            $table->string('adresse');
            $table->string('numero_fixe');
            $table->string('numero_portable');
            $table->string('cin');
            $table->integer('responsable');
            $table->integer('user_id');
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
        Schema::drop('families');
    }
}
