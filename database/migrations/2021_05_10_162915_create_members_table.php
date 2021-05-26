<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('nama_member');
            $table->string('kontak_member')->nullable();
            $table->string('alamat_member')->nullable();
            $table->timestamp('tgl_join');
            $table->integer('poin')->nullable();
            $table->decimal('diskon',16,2)->nullable();
            $table->timestamp('member_created_at', $precision = 0);
            $table->integer('member_created_by');
            $table->timestamp('member_modified_at', $precision = 0)->nullable();
            $table->integer('member_modified_by')->nullable();
            $table->softDeletes($column = 'member_deleted_at', $precision = 0);
            $table->integer('member_deleted_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members');
    }
}
