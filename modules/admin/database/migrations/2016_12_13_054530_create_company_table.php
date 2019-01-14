<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company', function (Blueprint $table) {
            $table->increments('id');
            $table->string('company_name',512)->nullable();
            $table->string('address_one',512)->nullable();
            $table->string('address_two',512)->nullable();
            $table->string('address_three',512)->nullable();
            $table->string('address_four',512)->nullable();
            $table->string('contact_person',64)->nullable();
            $table->string('designation',64)->nullable();
            $table->string('phone',64)->nullable();
            $table->string('mobile',64)->nullable();
            $table->string('email',64)->nullable();
            $table->string('web_address',64)->nullable();
            $table->enum('status',array('active','inactive','cancel'))->nullable();
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
        Schema::drop('company');
    }
}
