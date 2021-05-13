<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    const CREATED_AT = 'barang_created_at';
    const UPDATED_AT = 'barang_modified_at';
    const DELETED_AT = 'barang_deleted_at';
  
    use HasFactory, SoftDeletes;
    protected $table = 'barang';
    protected $fillable = [
          'supplier_id',
          'photo_file_id',
          'kategori_barang_id',
          'nama_barang',
          'qty',
          'harga_modal',
          'harga_jual',
          'satuan',
          'qty_per_satuan',
          'barcode',
          'barang_created_at',
          'barang_created_by',
          'barang_modified_at',
          'barang_modified_by',
          'barang_deleted_at',
          'barang_deleted_by'
      ];
}
