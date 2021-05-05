<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Auth\Passwords\CanResetPassword;
use Laravel\Sanctum\HasApiTokens;
use DB;

class User extends Authenticatable
{
	use HasApiTokens, HasFactory, Notifiable;

	public $timestamps = false;
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'username',
		'email',
		'password',
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
		$permissions = $query->join('jabatan as j', 'jabatan_id', 'user_jabatan_id')
			->select(DB::raw('string_agg(hak_akses, \',\') as permissions'))->first();
		if(!empty($permissions->hak_akses))
      $perms = explode(",",$permissions->hak_akses);
      
    return $perms;
	}
}
