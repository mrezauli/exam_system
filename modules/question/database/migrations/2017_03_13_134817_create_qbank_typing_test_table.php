<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQbankTypingTestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qbank_typing_test', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('exam_type',array('bangla','english'))->nullable();
            $table->text('typing_question')->nullable();
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
        Schema::drop('qbank_typing_test');
    }
}

