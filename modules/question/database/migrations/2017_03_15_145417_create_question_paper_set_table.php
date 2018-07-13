<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionPaperSetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
        {
            Schema::create('question_paper_set', function (Blueprint $table) {
                $table->increments('id');
                $table->string('question_set_title',100)->nullable();
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
            Schema::drop('question_paper_set');
        }
}
