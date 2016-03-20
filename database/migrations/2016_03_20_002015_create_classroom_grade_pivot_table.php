<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassroomGradePivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classroom_grade', function (Blueprint $table) {
            $table->integer('classroom_id')->unsigned()->index();
            $table->foreign('classroom_id')->references('id')->on('classrooms')->onDelete('cascade');
            $table->integer('grade_id')->unsigned()->index();
            $table->foreign('grade_id')->references('id')->on('grades')->onDelete('cascade');
            $table->primary(['classroom_id', 'grade_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('classroom_grade');
    }
}
