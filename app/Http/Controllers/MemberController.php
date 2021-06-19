<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;
use DB;
use Validator;

use App\Models\Member;
use App\Helpers\Utils;

class MemberController extends Controller
{
	public function getAll(Request $request)
	{
    $respon = Utils::$responses;

		$respon['success'] = true;
		$respon['state_code'] = 200;
		$respon['data'] = Member::all();

    return response()->json($respon, $respon['state_code']);
	}

	public function getById(Request $request, $id)
	{
    $respon = Utils::$responses;

		$data = Member::where('id', $id)
			->select(
				'id',
				'nama_member',
				'kontak_member',
				'alamat_member',
				'tgl_join',
				'poin',
				'diskon',
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
			'nama_member' => 'required',
			'tgl_join' => 'required'
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
			if(isset($inputs['id']) && $inputs['id'] != 0){
				$data = Member::find($inputs['id']);
				if($data == null){
					$respon['state_code'] = 404;
					array_push($respon['messages'],'Member tidak ditemukan.');

					return response()->json($respon, $respon['state_code']);
				}
				
				$data->update([
					'nama_member' => $inputs['nama_member'],
					'kontak_member' => $inputs['kontak_member'] == 'null' ?  null : $inputs['kontak_member'],
					'alamat_member' => $inputs['alamat_member'] == 'null' ?  null : $inputs['alamat_member'],
					'tgl_join' => $inputs['tgl_join'],
					'poin' => $inputs['poin'] == 'null' ?  null : $inputs['poin'],
					'diskon' => $inputs['diskon'] == 'null' ?  null : $inputs['diskon'],
					'member_modified_by' => $loginid
				]);
				array_push($respon['messages'],'Member berhasil diubah.');
			} else {
				$data = Member::create([
					'nama_member' => $inputs['nama_member'],
					'kontak_member' => $inputs['kontak_member'] == 'null' ?  null : $inputs['kontak_member'],
					'alamat_member' => $inputs['alamat_member'] == 'null' ?  null : $inputs['alamat_member'],
					'tgl_join' => $inputs['tgl_join'],
					'poin' => $inputs['poin'] == 'null' ?  null : $inputs['poin'],
					'diskon' => $inputs['diskon'] == 'null' ?  null : $inputs['diskon'],
					'member_created_by' => $loginid
				]);
				array_push($respon['messages'],'Member berhasil ditambah.');
			}
			
		$respon['data'] = $data;
		$respon['success'] = true;
		$respon['state_code'] = 200;
		

		}catch(\Exception $e){
			$respon['state_code'] = 500;
			array_push($respon['messages'],'Kesalahan! Member tidak dapat diproses.');
			dd($e);
		}
		
    return response()->json($respon, $respon['state_code']);
	}

	public function delete($id)
	{
    $respon = Utils::$responses;

		$data = Member::find($id);
		if($data != null){
			$data->update([
				'member_deleted_at' => DB::raw("now"),
				'member_deleted_by' => Auth::user()->getAuthIdentifier()
			]);

			$respon['success'] = true;
			$respon['state_code'] = 200;
			array_push($respon['messages'],'Member berhasil dihapus.');
		} else {
			$respon['state_code'] = 500;
			array_push($respon['messages'],'Kesalahan! Member tidak ditemukan.');
		}

    return response()->json($respon, $respon['state_code']);
	}
}
