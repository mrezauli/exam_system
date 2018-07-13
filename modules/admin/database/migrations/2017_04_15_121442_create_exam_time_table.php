<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamTimeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_time', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('exam_type',array('typing_exam','aptitude_exam'))->nullable();
            $table->integer('exam_time', false, 11)->nullable();
            $table->enum('status',array('active','inactive'))->nullable();
            $table->integer('created_by', false, 11)->nullable();
            $table->integer('updated_by', false, 11)->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('exam_time');
    }
}
