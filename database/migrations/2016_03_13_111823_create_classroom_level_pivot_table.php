<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassroomLevelPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classroom_level', function (Blueprint $table) {
            $table->integer('classroom_id')->unsigned()->index();
            $table->foreign('classroom_id')->references('id')->on('classrooms')->onDelete('cascade');
            $table->integer('level_id')->unsigned()->index();
            $table->foreign('level_id')->references('id')->on('levels')->onDelete('cascade');
            $table->primary(['classroom_id', 'level_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('classroom_level');
    }
}
