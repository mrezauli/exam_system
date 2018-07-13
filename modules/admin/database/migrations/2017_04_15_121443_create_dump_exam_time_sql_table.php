<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDumpExamTimeSqlTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared(file_get_contents("modules/admin/database/sql_dump/company.sql"));
        DB::unprepared(file_get_contents("modules/admin/database/sql_dump/exam_time.sql"));
        DB::unprepared(file_get_contents("modules/admin/database/sql_dump/bcc_email.sql"));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
