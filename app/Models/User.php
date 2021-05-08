<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Auth\Passwords\CanResetPassword;
use Laravel\Sanctum\HasApiTokens;
use DB;

class User extends Authenticatable
{
	const CREATED_AT = 'user_created_at';
  const UPDATED_AT = 'user_modified_at';
  const DELETED_AT = 'user_deleted_at';

	use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */

	protected $table = 'users';
	protected $fillable = [
		'jabatan_id',
		'photo_file_id',
		'username',
		'password',
		'nama_lengkap',
		'kontak',
		'alamat',
		'tgl_gabung',
		'jenis_kelamin',
		'remember_token',
		'user_created_at',
		'user_created_by',
		'user_modified_at',
		'user_modified_by',
		'user_deleted_at',
		'user_deleted_by'

	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password',
	];

	public function getAuthIdentifier()
  {
    return $this->id;
  }

	public function getJabatan()
  {
    return $this->jabatan_id;
		$q = DB::table('jabatan')
			->where('id', $this->jabatan_id)
			->select('nama_jabatan');
  }

	public function scopeGetPerms($query)
	{
		$perms = [];
		$permissions = $query->join('jabatan as j', 'j.id', 'jabatan_id')
			->select(DB::raw('string_agg(hak_akses, \',\') as permissions'))->first();
		if(!empty($permissions->hak_akses))
      $perms = explode(",",$permissions->hak_akses);
      
    return $perms;
	}
}
