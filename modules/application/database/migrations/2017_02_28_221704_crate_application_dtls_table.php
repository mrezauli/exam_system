<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrateApplicationDtlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organization_application_dtls', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('org_app_mst_id')->nullable();
            $table->string('subject',200)->nullable();
            $table->string('to_email',200)->nullable();
            $table->text('to_person')->nullable();
            $table->string('from_email',200)->nullable();
            $table->date('date_email')->nullable();
            $table->enum('read_email',array('true','false'))->nullable();
            $table->string('yours_only',200)->nullable();
            $table->string('letter_no',64)->nullable();
            $table->string('reference_no',200)->nullable();
            $table->text('email_description')->nullable();
            $table->enum('status',array('active','inactive'))->nullable();
            $table->integer('created_by', false, 11)->nullable();
            $table->integer('updated_by', false, 11)->nullable();
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

        Schema::table('organization_application_dtls', function($table) {
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
        Schema::drop('organization_application_dtls');
    }
}
