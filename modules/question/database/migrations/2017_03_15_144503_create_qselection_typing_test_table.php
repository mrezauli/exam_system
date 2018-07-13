<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQselectionTypingTestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qselection_typing_test', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('qbank_typing_id')->nullable();
            $table->unsignedInteger('company_id')->nullable();
            $table->unsignedInteger('designation_id')->nullable();
            $table->unsignedInteger('exam_code_id')->nullable();
            $table->date('exam_date')->nullable();
            $table->enum('exam_type',array('bangla','english'))->nullable();
            $table->enum('shift',array('s1','s2','s3','s4','s5'))->nullable();
            $table->enum('status',array('active','inactive'))->nullable();
            $table->integer('created_by', false, 11)->nullable();
            $table->integer('updated_by', false, 11)->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        Schema::table('qselection_typing_test', function($table) {
            $table->foreign('qbank_typing_id')->references('id')->on('qbank_typing_test');
        });

        Schema::table('qselection_typing_test', function($table) {
            $table->foreign('company_id')->references('id')->on('company');
        });

        Schema::table('qselection_typing_test', function($table) {
            $table->foreign('designation_id')->references('id')->on('designation');
        });

        Schema::table('qselection_typing_test', function($table) {
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
        Schema::drop('qselection_typing_test');
    }
}


