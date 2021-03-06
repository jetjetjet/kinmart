<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_jabatan_id')->nullable();
            $table->bigInteger('photo_file_id')->nullable();
            $table->string('nama_lengkap');
            $table->string('username')->unique();
            $table->string('password');
            $table->string('kontak')->nullable();
            $table->string('alamat')->nullable();
            $table->dateTime('tgl_gabung')->nullable();
            $table->string('jenis_kelamin')->nullable();
            $table->string('remember_token')->nullable();
            $table->boolean('user_active');
            $table->dateTime('user_created_at');
            $table->integer('user_created_by');
            $table->dateTime('user_modified_at')->nullable();
            $table->integer('user_modified_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
