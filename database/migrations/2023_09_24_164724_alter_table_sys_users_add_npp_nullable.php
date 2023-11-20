<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableSysUsersAddNppNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table(
            'sys_users',
            function (Blueprint $table) {
                $table->string('npp')->after('name')->nullable();

            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table(
            'sys_users',
            function (Blueprint $table) {
                $table->dropColumn(['npp']);
            }
        );
    }
}
