<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barang', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('supplier_id')->nullable();
            $table->bigInteger('photo_file_id')->nullable();
            $table->bigInteger('kategori_barang_id');
            $table->string('nama_barang');
            $table->integer('qty');
            $table->decimal('harga_modal',16,2)->nullable();
            $table->decimal('harga_jual',16,2)->nullable();
            $table->string('satuan')->nullable();
            $table->integer('qty_per_satuan')->nullable();
            $table->string('barcode')->nullable();
            $table->timestamp('barang_created_at', $precision = 0);
            $table->integer('barang_created_by');
            $table->timestamp('barang_modified_at', $precision = 0)->nullable();
            $table->integer('barang_modified_by')->nullable();
            $table->softDeletes($column = 'barang_deleted_at', $precision = 0);
            $table->integer('barang_deleted_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barang');
    }
}
