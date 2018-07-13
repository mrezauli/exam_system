<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionSetQbankAptitudeTestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
            {
                Schema::create('question_set_qbank_aptitude_test', function (Blueprint $table) {
                    $table->increments('id');
                    $table->unsignedInteger('qbank_aptitude_id')->nullable();
                    $table->unsignedInteger('question_set_id')->nullable();
                    $table->string('question_mark',64)->nullable();
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
                Schema::drop('question_set_qbank_aptitude_test');
            }
}
