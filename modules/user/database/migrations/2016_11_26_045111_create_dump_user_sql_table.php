<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDumpUserSqlTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared(file_get_contents("modules/user/database/sql_dump/department.sql"));
        DB::unprepared(file_get_contents("modules/user/database/sql_dump/role.sql"));
        DB::unprepared(file_get_contents("modules/user/database/sql_dump/user.sql"));
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
