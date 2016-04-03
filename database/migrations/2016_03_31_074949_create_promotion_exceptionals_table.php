<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromotionExceptionalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotion_exceptionals', function (Blueprint $table) {
            $table->increments('id');
            $table->date('start');
            $table->date('end');
            $table->integer('price');
            $table->integer('user_id')->unsigned();
            $table->boolean('active')->default(0);
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
        Schema::drop('promotion_exceptionals');
    }
}
