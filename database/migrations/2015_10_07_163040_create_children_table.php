<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChildrenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('children', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nom_enfant');
            $table->integer('age_enfant');
            $table->date('date_naissance');
            $table->string('photo');
            $table->integer('family_id');
            $table->integer('user_id')->unsigned();
            $table->integer('f_id')->unsigned();
            $table->integer('transport')->unsigned()->default(0);
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
        Schema::drop('children');
    }
}
