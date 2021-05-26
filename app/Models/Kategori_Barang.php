<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Kategori_Barang extends Model
{
     //custom created and modified
     const CREATED_AT = 'kb_created_at';
     const UPDATED_AT = 'kb_modified_at';
     const DELETED_AT = 'kb_deleted_at';
 
     use HasFactory, SoftDeletes;
     protected $table = 'kategori_barang';
     protected $fillable = [
         'nama_kb',
         'deskripsi_kb',
         'kb_created_by',
         'kb_created_at',
         'kb_modified_at',
         'kb_modified_by',
         'kb_deleted_at',
         'kb_deleted_by',
     ];
 }
 