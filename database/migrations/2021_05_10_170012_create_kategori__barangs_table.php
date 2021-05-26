<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKategoriBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kategori_barang', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kb');
            $table->string('deskripsi_kb')->nullable();
            $table->integer('kb_created_by');
            $table->timestamp('kb_created_at');
            $table->timestamp('kb_modified_at')->nullable();
            $table->integer('kb_modified_by')->nullable();
            $table->timestamp('kb_deleted_at')->nullable();
            $table->integer('kb_deleted_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kategori_barang');
    }
}
