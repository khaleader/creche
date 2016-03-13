<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('site_web');
            $table->string('page_facebook');
            $table->string('patente');
            $table->string('registre_du_commerce');
            $table->string('identification_fiscale');
            $table->string('cnss');
            $table->string('rib');
            $table->integer('user_id')->unsigned();
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
        Schema::drop('profiles');
    }
}
