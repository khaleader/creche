<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCombienAndReductionToBills extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bills', function (Blueprint $table) {
            $table->integer('nbrMois')->unsigned();
            $table->string('reductionPrix',50)->nullable();
            $table->boolean('reduction');
            $table->integer('school_year_id')->unsigned()->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bills', function (Blueprint $table) {
            $table->dropColumn('nbrMois');
            $table->dropColumn('reductionPrix');
            $table->dropColumn('reduction');
            $table->dropColumn('school_year_id');

        });
    }
}
