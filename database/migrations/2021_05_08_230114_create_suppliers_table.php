<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('kontak')->nullable();
            $table->string('alamat')->nullable();
            $table->timestamp('supplier_created_at');
            $table->integer('supplier_created_by');
            $table->timestamp('supplier_modified_at')->nullable();
            $table->integer('supplier_modified_by')->nullable();
            $table->softDeletes($column = 'supplier_deleted_at', $precision = 0)->nullable();
            $table->integer('supplier_deleted_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('suppliers');
    }
}
