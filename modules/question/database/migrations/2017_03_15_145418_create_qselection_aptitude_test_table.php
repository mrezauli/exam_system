<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQselectionAptitudeTestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qselection_aptitude_test', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('question_type',array('word','excel','ppt'))->nullable();
            $table->unsignedInteger('question_set_id')->nullable();
            $table->unsignedInteger('qbank_aptitude_id')->nullable();
            $table->unsignedInteger('company_id')->nullable();
            $table->unsignedInteger('designation_id')->nullable();
            $table->unsignedInteger('exam_code_id')->nullable();
            $table->date('exam_date')->nullable();
            $table->enum('shift',array('s1','s2','s3','s4','s5'))->nullable();
            $table->enum('status',array('active','inactive'))->nullable();
            $table->decimal('question_marks', 20,2)->nullable();
            $table->integer('created_by', false, 11)->nullable();
            $table->integer('updated_by', false, 11)->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        Schema::table('qselection_aptitude_test', function($table) {
            $table->foreign('qbank_aptitude_id')->references('id')->on('qbank_aptitude_test');
        });

        Schema::table('qselection_aptitude_test', function($table) {
            $table->foreign('company_id')->references('id')->on('company');
        });

        Schema::table('qselection_aptitude_test', function($table) {
            $table->foreign('designation_id')->references('id')->on('designation');
        });

        Schema::table('qselection_aptitude_test', function($table) {
            $table->foreign('exam_code_id')->references('id')->on('exam_code');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('qselection_aptitude_test');
    }
}



