<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExaminerSelectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('examiner_selection', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('examiner_id')->nullable();
            $table->unsignedInteger('company_id')->nullable();
            $table->unsignedInteger('designation_id')->nullable();
            $table->unsignedInteger('exam_code_id')->nullable();
            $table->date('exam_date')->nullable();
            $table->enum('status',array('active','inactive'))->nullable();
            $table->integer('created_by', false, 11)->nullable();
            $table->integer('updated_by', false, 11)->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        Schema::table('examiner_selection', function($table) {
            $table->foreign('examiner_id')->references('id')->on('user');
        });

        Schema::table('examiner_selection', function($table) {
            $table->foreign('company_id')->references('id')->on('company');
        });

        Schema::table('examiner_selection', function($table) {
            $table->foreign('designation_id')->references('id')->on('designation');
        });

        Schema::table('examiner_selection', function($table) {
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
        Schema::drop('examiner_selection');
    }
}
