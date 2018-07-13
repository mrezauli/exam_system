<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTemplateExtraInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('template_extra_information', function (Blueprint $table) {
        $table->increments('id');
        $table->unsignedInteger('org_app_mst_id')->nullable();
        $table->enum('extra_information_type',array('reference_no','copy','distribution'))->nullable();
        $table->text('extra_information')->nullable();
        $table->enum('status',array('active','inactive'))->nullable();
        $table->integer('created_by', false, 11)->nullable();
        $table->integer('updated_by', false, 11)->nullable();
        $table->timestamps();
        $table->engine = 'InnoDB';
        });

        Schema::table('template_extra_information', function($table) {
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
        Schema::drop('template_extra_information');
    }
}
