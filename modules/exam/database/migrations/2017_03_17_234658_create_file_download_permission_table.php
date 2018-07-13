<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFileDownloadPermissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_download_permission', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('qselection_aptitude_id')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->enum('question_type',array('word','excel','ppt'))->nullable();
            $table->tinyInteger('open_flag')->default('0');
            $table->enum('status',array('active','inactive'))->nullable();
            $table->integer('created_by', false, 11)->nullable();
            $table->integer('updated_by', false, 11)->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        Schema::table('file_download_permission', function($table) {
            $table->foreign('qselection_aptitude_id')->references('id')->on('qselection_aptitude_test');
        });

        Schema::table('file_download_permission', function($table) {
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
        Schema::drop('file_download_permission');
    }
}
