<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJabatansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jabatan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_jabatan');
            $table->string('deskripsi_jabatan')->nullable();
            $table->string('hak_akses')->nullable();
            $table->boolean('is_admin')->nullable();
            $table->timestamp('jabatan_created_at', $precision = 0);
            $table->integer('jabatan_created_by');
            $table->timestamp('jabatan_modified_at', $precision = 0)->nullable();
            $table->integer('jabatan_modified_by')->nullable();
            $table->softDeletes($column = 'jabatan_deleted_at', $precision = 0);
            $table->integer('jabatan_deleted_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jabatan');
    }
}
