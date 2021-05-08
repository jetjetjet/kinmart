<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;
use DB;
use Validator;
use Hash;

use App\Models\User;
use App\Helpers\Utils;

class UserController extends Controller
{
	public function getAll(Request $request)
	{
    $respon = Utils::$responses;

		$respon['success'] = true;
		$respon['state_code'] = 200;
		$respon['data'] = User::all();

    return response()->json($respon, $respon['state_code']);
	}

	public function getById(Request $request, $id)
	{
    $respon = Utils::$responses;

		$data = User::where('users.id', $id)
      ->leftJoin('jabatan as j', 'jabatan_id', '=', 'j.id')
			->select(
        'jabatan_id',
        'photo_file_id',
        'username',
        'password',
        'nama_lengkap',
        'kontak',
        'alamat',
        'tgl_gabung',
        'jenis_kelamin',
			)->first();
		if(!empty($data)){
			$respon['success'] = true;
			$respon['state_code'] = 200;
			$respon['data'] = $data;
		}
    return response()->json($respon, $respon['state_code']);
	}

	public function getProfile(Request $request)
	{

	}

	public function save(Request $request)
	{
    $respon = Utils::$responses;

		$rules = array(
			'username' => 'required'
		);

		$inputs = $request->all();
		$respon['data'] = $inputs;
		$loginid = Auth::user()->getAuthIdentifier();

		$validator = Validator::make($inputs, $rules);
		if ($validator->fails()){
      $respon['messages'] = $validator->errors()->all();
      return response()->json($respon, $respon['state_code']);
		}

		try{
			if(isset($inputs['id'])){
				$data = User::find($inputs['id']);
				if($data == null){
					$respon['state_code'] = 404;
					array_push($respon['messages'],'User tidak ditemukan.');

					return response()->json($respon, $respon['state_code']);
				}
				
				$data->update([
					'username' => $inputs['username'],
					'kontak' => $inputs['kontak'] ?? null,
          'user_jabatan_id' => $inputs['user_jabatan_id'] ?? null,
					'alamat' => $inputs['alamat'] ?? null,
					'jenis_kelamin' => $inputs['jenis_kelamin'],
					'user_modified_by' => $loginid
				]);
				array_push($respon['messages'],'User berhasil diubah.');
			} else {
				$data = User::create([
					'username' => $inputs['username'],
          'password' => Hash::make($inputs['password']),
          'nama_lengkap' => $inputs['nama_lengkap'],
          'tgl_gabung' => $inputs['tgl_gabung'],
					'kontak' => $inputs['kontak'] ?? null,
          'user_jabatan_id' => $inputs['user_jabatan_id'] ?? null,
					'alamat' => $inputs['alamat'] ?? null,
					'jenis_kelamin' => $inputs['jenis_kelamin'],
					'user_created_by' => $loginid
				]);
        array_push($respon['messages'],'User berhasil ditambah.');
			}
			
		$respon['data'] = $data;
		$respon['success'] = true;
		$respon['state_code'] = 200;
		

		}catch(\Exception $e){
			$respon['state_code'] = 500;
			array_push($respon['messages'],'Kesalahan! User tidak dapat diproses.');
		}
		
    return response()->json($respon, $respon['state_code']);
	}

	public function delete($id)
	{
    $respon = Utils::$responses;

		$data = User::find($id);
		if($data != null){
			$data->update([
				'user_deleted_at' => DB::raw("now"),
				'user_deleted_by' => Auth::user()->getAuthIdentifier()
			]);

			$respon['success'] = true;
			$respon['state_code'] = 200;
			array_push($respon['messages'],'User berhasil dihapus.');
		} else {
			$respon['state_code'] = 500;
			array_push($respon['messages'],'Kesalahan! User tidak ditemukan.');
		}

    return response()->json($respon, $respon['state_code']);
	}

  public function password(request $request, $id)
  {
    $respon = Utils::$responses;

    $rules = array(
      'password' => 'required'
		);
    $inputs = $request->all();

    $validator = Validator::make($inputs, $rules);
		if ($validator->fails()){
      $respon['messages'] = $validator->errors()->all();
      return response()->json($respon, $respon['state_code']);
		}

		$data = User::find($id);
		if($data != null){
			$data->update([
				'password' => Hash::make($inputs['password']),
				'user_modified_by' => Auth::user()->getAuthIdentifier()
			]);

			$respon['success'] = true;
			$respon['state_code'] = 200;
			array_push($respon['messages'],'Password Berhasil diganti.');
		} else {
			$respon['state_code'] = 500;
			array_push($respon['messages'],'Kesalahan! Password tidak diganti.');
		}

    return response()->json($respon, $respon['state_code']);
  }
}
