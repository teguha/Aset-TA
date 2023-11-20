<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'ref_vendor',
            function (Blueprint $table) {
                $table->id();
                $table->string("id_vendor")->unique();
                $table->string("name");
                $table->longText("address")->nullable();
                $table->string("telp")->nullable();
                $table->string("email")->nullable();
                $table->string('contact_person')->nullable();
                $table->commonFields();
            }
        );

        Schema::create('ref_type_vendor_details', function (Blueprint $table) {
            $table->unsignedBigInteger('type_id');
            $table->unsignedBigInteger('vendor_id');

            $table->foreign('type_id')->references('id')->on('ref_type_vendor')->onDelete('cascade');
            $table->foreign('vendor_id')->references('id')->on('ref_vendor');

            $table->primary(['type_id', 'vendor_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ref_vendor');
    }
}
