<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQBankAptitudeTestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qbank_aptitude_test', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title',100)->nullable();
            $table->enum('question_type',array('word','excel','ppt'))->nullable();
            $table->string('original_file_path',100)->nullable();
            $table->string('image_file_path',100)->nullable();
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
        Schema::drop('qbank_aptitude_test');
    }
}


