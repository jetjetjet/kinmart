<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;
use DB;
use Validator;

use App\Models\Kategori_Barang;
use App\Helpers\Utils;

class KategoriBarangController extends Controller
{
	public function getAll(Request $request)
	{
    $respon = Utils::$responses;

		$respon['success'] = true;
		$respon['state_code'] = 200;
		$respon['data'] = Kategori_Barang::all();

    return response()->json($respon, $respon['state_code']);
	}

	public function getById(Request $request, $id)
	{
    $respon = Utils::$responses;

		$data = Kategori_Barang::where('id', $id)
			->select(
			'nama_kb',
            'deskripsi_kb',	
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
			'nama_kb' => 'required',
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
				$data = Kategori_Barang::find($inputs['id']);
				if($data == null){
					$respon['state_code'] = 404;
					array_push($respon['messages'],'Kategori Barang tidak ditemukan.');

					return response()->json($respon, $respon['state_code']);
				}
				
				$data->update([
					'nama_kb' => $inputs['nama_kb'],
					'deskripsi_kb' => $inputs['deskripsi_kb'] == 'null' ?  null : $inputs['deskripsi_kb'],
					'kb_modified_by' => $loginid
				]);
				array_push($respon['messages'],'Kategori Barang berhasil diubah.');
			} else {
				$data = Kategori_Barang::create([
					'nama_kb' => $inputs['nama_kb'],
					'deskripsi_kb' => $inputs['deskripsi_kb'] == 'null' ?  null : $inputs['deskripsi_kb'],
					'kb_created_by' => $loginid
				]);
                array_push($respon['messages'],'Kategori Barang berhasil ditambah.');

			}
			
		$respon['data'] = $data;
		$respon['success'] = true;
		$respon['state_code'] = 200;

		}catch(\Exception $e){
			$respon['state_code'] = 500;
			array_push($respon['messages'],'Kesalahan! Kategori Barang tidak dapat diproses.');
		}
		
    return response()->json($respon, $respon['state_code']);
	}

	public function delete($id)
	{
    $respon = Utils::$responses;

		$data = Kategori_Barang::find($id);
		if($data != null){
			$data->update([
				'kb_deleted_at' => DB::raw("now"),
				'kb_deleted_by' => Auth::user()->getAuthIdentifier()
			]);

			$respon['success'] = true;
			$respon['state_code'] = 200;
			array_push($respon['messages'],'Kategori Barang berhasil dihapus.');
		} else {
			$respon['state_code'] = 500;
			array_push($respon['messages'],'Kesalahan! Kategori Barang tidak ditemukan.');
		}

    return response()->json($respon, $respon['state_code']);
	}
}
