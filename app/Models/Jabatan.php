<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
  //custom created and modified
  const CREATED_AT = 'jabatan_created_at';
  const UPDATED_AT = 'jabatan_modified_at';
  const DELETED_AT = 'jabatan_deleted_at';

  use HasFactory, SoftDeletes;
  protected $table = 'jabatan';
  protected $primaryKey = 'jabatan_id';
  protected $fillable = [
		'nama_jabatan',
		'deskripsi_jabatan',
		'hak_akses',
		'is_admin',
		'jabatan_created_at',
		'jabatan_created_by',
		'jabatan_modified_at',
		'jabatan_modified_by',
		'jabatan_deleted_at',
		'jabatan_deleted_by'
	];
}