<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAptitudeExamResultTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aptitude_exam_result', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('qselection_aptitude_id')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->enum('question_type',array('word','excel','ppt'))->nullable();
            //$table->string('question_original_file_path',100)->nullable();
            //$table->string('question_image_file_path',100)->nullable();
            $table->string('answer_original_file_path',100)->nullable();
            $table->string('answer_image_file_path',100)->nullable();
            $table->tinyInteger('re_submit_flag')->default('0');
            $table->enum('status',array('active','inactive'))->nullable();
            $table->decimal('answer_marks', 20,2)->nullable();
            $table->integer('created_by', false, 11)->nullable();
            $table->integer('updated_by', false, 11)->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        Schema::table('aptitude_exam_result', function($table) {
            $table->foreign('qselection_aptitude_id')->references('id')->on('qselection_aptitude_test');
        });

        Schema::table('aptitude_exam_result', function($table) {
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
        Schema::drop('aptitude_exam_result');
    }
}




