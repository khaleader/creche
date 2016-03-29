<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchoolYearsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_years', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ann_scol',255);
            $table->string('type',255);
            $table->date('startch1');
            $table->date('endch1');
            $table->date('startch2');
            $table->date('endch2');
            $table->date('startch3')->nullable();
            $table->date('endch3')->nullable();
            $table->integer('user_id')->unsigned();
            $table->boolean('current');
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
        Schema::drop('school_years');
    }
}
