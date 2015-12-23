<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nom_responsable')->nullable();
            $table->string('type');
            $table->string('tel_fixe')->nullable();
            $table->string('tel_portable')->nullable();
            $table->text('adresse')->nullable();
            $table->text('ville')->nullable();
            $table->text('pays')->nullable();
            $table->text('photo');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
          $table->drop();
        });
    }
}
