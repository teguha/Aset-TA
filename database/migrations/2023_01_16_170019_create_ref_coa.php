<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefCoa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'ref_coa',
            function (Blueprint $table) {
                $table->id();
                $table->string('kode_akun')->unique();
                $table->string('nama_akun')->nullable();
                $table->enum('tipe_akun', ['KIB A', 'KIB B', 'KIB C', 'KIB D', 'KIB E', 'KIB F'])->nullable();
                $table->string('deskripsi')->nullable();
                $table->commonFields();
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
        Schema::drop('ref_coa');
    }
}
