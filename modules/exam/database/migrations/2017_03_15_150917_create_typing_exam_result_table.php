<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTypingExamResultTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('typing_exam_result', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('qselection_typing_id')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->enum('exam_type',array('bangla','english'))->nullable();
            $table->integer('exam_time', false, 11)->nullable();
            $table->boolean('started')->nullable();
            $table->boolean('completed')->nullable();
            $table->text('original_text')->nullable();
            $table->text('answered_text')->nullable();
            $table->text('process_text')->nullable();
            $table->integer('total_words', false, 11)->nullable();
            $table->integer('typed_words', false, 11)->nullable();
            $table->integer('inserted_words', false, 11)->nullable();
            $table->integer('deleted_words', false, 11)->nullable();
            $table->float('accuracy', 11, 3)->nullable();
            $table->float('wpm', 11, 3)->nullable();
            $table->enum('status',array('active','inactive'))->nullable();
            $table->integer('created_by', false, 11)->nullable();
            $table->integer('updated_by', false, 11)->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        Schema::table('typing_exam_result', function($table) {
            $table->foreign('qselection_typing_id')->references('id')->on('qselection_typing_test');
        });

        Schema::table('typing_exam_result', function($table) {
            $table->foreign('user_id')->references('id')->on('user');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('typing_exam_result');
    }
}



