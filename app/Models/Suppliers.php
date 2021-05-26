<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class suppliers extends Model
{
    //custom created and modified
    const CREATED_AT = 'supplier_created_at';
    const UPDATED_AT = 'supplier_modified_at';
    const DELETED_AT = 'supplier_deleted_at';

    use HasFactory, SoftDeletes;
    protected $table = 'suppliers';
    protected $fillable = [
        'nama',
        'kontak',
        'alamat',
        'supplier_created_at',
        'supplier_created_by',
        'supplier_modified_at',
        'supplier_modified_by',
        'supplier_deleted_at',
        'supplier_deleted_by',
    ];
}
