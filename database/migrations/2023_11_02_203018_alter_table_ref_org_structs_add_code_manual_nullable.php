<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableRefOrgStructsAddCodeManualNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('ref_org_structs', function (Blueprint $table) {
            $table->string('code_manual')->nullable()->after('code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('ref_org_structs', function (Blueprint $table) {
            $table->dropColumn('code_manual');
        });
    }
}
