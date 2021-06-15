<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;
use DB;
use Validator;

use App\Models\Suppliers;
use App\Helpers\Utils;

class SuppliersController extends Controller
{
	public function getAll(Request $request)
	{
    $respon = Utils::$responses;

		$respon['success'] = true;
		$respon['state_code'] = 200;
		$respon['data'] = Suppliers::all();

    return response()->json($respon, $respon['state_code']);
	}

	public function getById(Request $request, $id)
	{
    $respon = Utils::$responses;

		$data = Suppliers::where('id', $id)
			->select(
			'nama',
            'alamat',
            'kontak',	
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
			'nama' => 'required',
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
				$data = Suppliers::find($inputs['id']);
				if($data == null){
					$respon['state_code'] = 404;
					array_push($respon['messages'],'Suppliers tidak ditemukan.');

					return response()->json($respon, $respon['state_code']);
				}
				
				$data->update([
					'nama' => $inputs['nama'],
					'alamat' => $inputs['alamat'] == 'null' ?  null : $inputs['alamat'],
					'kontak' => $inputs['kontak'] == 'null' ?  null : $inputs['kontak'],
					'supplier_modified_by' => $loginid
				]);
				array_push($respon['messages'],'Suppliers berhasil diubah.');
			} else {
				$data = Suppliers::create([
					'nama' => $inputs['nama'],
					'alamat' => $inputs['alamat'] == 'null' ?  null : $inputs['alamat'],
					'kontak' => $inputs['kontak'] == 'null' ?  null : $inputs['kontak'],
					'supplier_created_by' => $loginid
				]);
                array_push($respon['messages'],'Suppliers berhasil ditambah.');

			}
			
		$respon['data'] = $data;
		$respon['success'] = true;
		$respon['state_code'] = 200;

		}catch(\Exception $e){
			$respon['state_code'] = 500;
			array_push($respon['messages'],'Kesalahan! Suppliers tidak dapat diproses.');
		}
		
    return response()->json($respon, $respon['state_code']);
	}

	public function delete($id)
	{
    $respon = Utils::$responses;

		$data = Suppliers::find($id);
		if($data != null){
			$data->update([
				'supplier_deleted_at' => DB::raw("now"),
				'supplier_deleted_by' => Auth::user()->getAuthIdentifier()
			]);

			$respon['success'] = true;
			$respon['state_code'] = 200;
			array_push($respon['messages'],'Suppliers berhasil dihapus.');
		} else {
			$respon['state_code'] = 500;
			array_push($respon['messages'],'Kesalahan! Suppliers tidak ditemukan.');
		}

    return response()->json($respon, $respon['state_code']);
	}
}
