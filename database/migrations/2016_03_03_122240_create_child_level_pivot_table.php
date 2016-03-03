<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChildLevelPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('child_level', function (Blueprint $table) {
            $table->integer('child_id')->unsigned()->index();
            $table->foreign('child_id')->references('id')->on('children')->onDelete('cascade');
            $table->integer('level_id')->unsigned()->index();
            $table->foreign('level_id')->references('id')->on('levels')->onDelete('cascade');
            $table->primary(['child_id', 'level_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('child_level');
    }
}
