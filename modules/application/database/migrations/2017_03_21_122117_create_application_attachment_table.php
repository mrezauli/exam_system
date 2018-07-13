<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicationAttachmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_attachment', function (Blueprint $table) {
        $table->increments('id');
        $table->unsignedInteger('org_app_mst_id')->nullable();
        $table->string('application_attachment_path',200)->nullable();
        $table->enum('attachment_type',array('file_upload','template_main','template_extra'))->nullable();
        $table->enum('status',array('active','inactive'))->nullable();
        $table->integer('created_by', false, 11)->nullable();
        $table->integer('updated_by', false, 11)->nullable();
        $table->timestamps();
        $table->engine = 'InnoDB';
        });

        Schema::table('application_attachment', function($table) {
            $table->foreign('org_app_mst_id')->references('id')->on('organization_application_mst');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('application_attachment');
    }
}
