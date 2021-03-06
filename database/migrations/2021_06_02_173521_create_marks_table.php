<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('mark_date');
            $table->string('lat');
            $table->string('lng');
            $table->integer('user_id')->unsigned();
            $table->integer('mark_type_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('mark_type_id')->references('id')->on('mark_type');
            $table->text('picture');
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
        Schema::dropIfExists('marks');
    }
}
