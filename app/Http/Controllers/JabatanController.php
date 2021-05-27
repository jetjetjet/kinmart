<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;
use DB;
use Validator;

use App\Models\Jabatan;
use App\Helpers\Utils;

class JabatanController extends Controller
{
	public function getAll(Request $request)
	{
    $respon = Utils::$responses;

		$respon['success'] = true;
		$respon['state_code'] = 200;
		$respon['data'] = Jabatan::all();

    return response()->json($respon, $respon['state_code']);
	}

	public function getById(Request $request, $id)
	{
    $respon = Utils::$responses;

		$data = Jabatan::findOrFail($id);
dd($data);
			$data->leftJoin('users as mod', 'mod.id', 'jabatan_modified_by')
			->leftJoin('users as crt', 'crt.id', 'jabatan_created_by')
			->select(
				'jabatan.id',
				'nama_jabatan',
				'deskripsi_jabatan',
				'hak_akses',
				'is_admin',
				'jabatan_created_at',
				'crt.username as jabatan_created_by',
				'jabatan_modified_at',
				'mod.username as jabatan_modified_by'
			)->firstOrFail();
		
			dd($data);
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

		$rules = $request->validate([
			'nama_jabatan' => 'required',
	]);
	dd($rules);

		$inputs = $request->all();
		$respon['data'] = $inputs;
		$loginid = Auth::user()->getAuthIdentifier();

		$validator = Validator::make($inputs, $rules);
		if ($validator->fails()){
      $respon['messages'] = $validator->errors()->all();
      return response()->json($respon, $respon['state_code']);
		}

		$tes = Jabatan::UpdateOrCreate(
			[ 
				'id' => $request->id
			],
			[
				'nama_jabatan' => $inputs['nama_jabatan'],
				'deskripsi_jabatan' => $inputs['deskripsi_jabatan'] ?? null,
				'hak_akses' => $inputs['hak_akses'] ?? null,
				'is_admin' => $inputs['is_admin'] ?? null,
				'jabatan_created_by' => 1
			]);
		
		dd($tes);
		// try{
		// 	if(isset($inputs['id'])){
		// 		$data = Jabatan::find($inputs['id']);
		// 		if($data == null){
		// 			$respon['state_code'] = 404;
		// 			array_push($respon['messages'],'Jabatan tidak ditemukan.');

		// 			return response()->json($respon, $respon['state_code']);
		// 		}
				
		// 		$data->update([
		// 			'nama_jabatan' => $inputs['nama_jabatan'],
		// 			'deskripsi_jabatan' => $inputs['deskripsi_jabatan'] ?? null,
		// 			'hak_akses' => $inputs['hak_akses'] ?? null,
		// 			'is_admin' => $inputs['is_admin'] ?? null,
		// 			'jabatan_modified_by' => $loginid
		// 		]);

		// 		$respon['success'] = true;
		// 		$respon['state_code'] = 200;
		// 		array_push($respon['messages'],'Jabatan berhasil diubah.');
		// 	} else {
		// 		$data = Jabatan::create([
		// 			'nama_jabatan' => $inputs['nama_jabatan'],
		// 			'deskripsi_jabatan' => $inputs['deskripsi_jabatan'] ?? null,
		// 			'hak_akses' => $inputs['hak_akses'] ?? null,
		// 			'is_admin' => $inputs['is_admin'] ?? null,
		// 			'jabatan_created_by' => $loginid
		// 		]);
		// 	}
			
		// $respon['data'] = $data;
		// $respon['success'] = true;
		// $respon['state_code'] = 200;
		// array_push($respon['messages'],'Jabatan berhasil ditambah.');

		// }catch(\Exception $e){
		// 	$respon['state_code'] = 500;
		// 	array_push($respon['messages'],'Kesalahan! Jabatan tidak dapat diproses.');
		// }
		
    return response()->json($respon, $respon['state_code']);
	}

	public function delete($id)
	{
    $respon = Utils::$responses;

		$data = Jabatan::find($id);
		if($data != null){
			$data->update([
				'jabatan_deleted_at' => DB::raw("now"),
				'jabatan_deleted_by' => Auth::user()->getAuthIdentifier()
			]);

			$respon['success'] = true;
			$respon['state_code'] = 200;
			array_push($respon['messages'],'Jabatan berhasil dihapus.');
		} else {
			$respon['state_code'] = 500;
			array_push($respon['messages'],'Kesalahan! Jabatan tidak ditemukan.');
		}

    return response()->json($respon, $respon['state_code']);
	}
}
