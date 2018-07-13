<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrateApplicationMstTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organization_application_mst', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('company_id')->nullable();
            $table->enum('application_format',array('template','file_upload'))->nullable();
            $table->enum('bcc_or_organization',array('bcc','organization'))->nullable();
            $table->enum('status',array('active','inactive'))->nullable();
            $table->integer('created_by', false, 11)->nullable();
            $table->integer('updated_by', false, 11)->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
          

        Schema::table('organization_application_mst', function($table) {
            $table->foreign('user_id')->references('id')->on('user');
        });

        Schema::table('organization_application_mst', function($table) {
            $table->foreign('company_id')->references('id')->on('company');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('organization_application_mst');
    }
}
