<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    const CREATED_AT = 'member_created_at';
    const UPDATED_AT = 'member_modified_at';
    const DELETED_AT = 'member_deleted_at';
    
    use HasFactory, SoftDeletes;
    protected $table = 'members';
    protected $fillable = [
          'nama_member',
          'kontak_member',
          'alamat_member',
          'tgl_join',
          'poin',
          'diskon',
          'member_created_at',
          'member_created_by',
          'member_modified_at',
          'member_modified_by',
          'member_deleted_at',
          'member_deleted_by'
      ];
}
