<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBccEmailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bcc_email', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email_address',200)->unique();
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
        Schema::drop('bcc_email');
    }
}
