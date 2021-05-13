<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Auth;
use DB;
use Validator;

use App\Models\Barang;
use App\Helpers\Utils;

class BarangController extends Controller
{
	public function getAll(Request $request)
	{
    $respon = Utils::$responses;

		$respon['success'] = true;
		$respon['state_code'] = 200;
		$respon['data'] = Barang::all();

    return response()->json($respon, $respon['state_code']);
	}

	public function getById(Request $request, $id)
	{
    $respon = Utils::$responses;

		$data = Barang::where('id', $id)
			->leftJoin('kategori_barang as kb', 'kategori_barang_id', '=', 'kb.id')
			-leftJoin('suppliers as s', 'supplier_id', '=', 's.id')
			->select(
				'id',
				's.nama as nama_supplier',
				'photo_file_id',
				'nama_kb',
				'nama_barang',
				'qty',
				'harga_modal',
				'harga_jual',
				'satuan',
				'qty_per_satuan',
				'barcode'
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
			'kategori_barang_id' => 'required',
			'nama_barang' => 'required',
			'qty' => 'required'
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
				$data = Barang::find($inputs['id']);
				if($data == null){
					$respon['state_code'] = 404;
					array_push($respon['messages'],'Barang tidak ditemukan.');

					return response()->json($respon, $respon['state_code']);
				}
				
				$data->update([
					'supplier_id' => $inputs['supplier_id'] ?? null,
					'photo_file_id' => $inputs['photo_file_id'] ?? null,
					'kategori_barang_id' => $inputs['kategori_barang_id'],
					'nama_barang' => $inputs['nama_barang'],
					'qty' => $inputs['qty'],
					'harga_modal' => $inputs['harga_modal'] ?? null,
					'harga_jual' => $inputs['harga_jual'] ?? null,
					'satuan' => $inputs['satuan'] ?? null,
					'qty_per_satuan' => $inputs['qty_per_satuan'] ?? null,
					'barcode' => $inputs['barcode'] ?? null,
					'barang_modified_by' => $loginid
				]);
				array_push($respon['messages'],'Barang berhasil diubah.');
			} else {
				$data = Barang::create([
					'supplier_id' => $inputs['supplier_id'] ?? null,
					'photo_file_id' => $inputs['photo_file_id'] ?? null,
					'kategori_barang_id' => $inputs['kategori_barang_id'],
					'nama_barang' => $inputs['nama_barang'],
					'qty' => $inputs['qty'],
					'harga_modal' => $inputs['harga_modal'] ?? null,
					'harga_jual' => $inputs['harga_jual'] ?? null,
					'satuan' => $inputs['satuan'] ?? null,
					'qty_per_satuan' => $inputs['qty_per_satuan'] ?? null,
					'barcode' => $inputs['barcode'] ?? null,
					'barang_created_by' => $loginid
				]);
                array_push($respon['messages'],'Barang berhasil ditambah.');
			}
			
		$respon['data'] = $data;
		$respon['success'] = true;
		$respon['state_code'] = 200;
		

		}catch(\Exception $e){
			$respon['state_code'] = 500;
			array_push($respon['messages'],'Kesalahan! Barang tidak dapat diproses.');
		}
		
    return response()->json($respon, $respon['state_code']);
	}

	public function delete($id)
	{
    $respon = Utils::$responses;

		$data = Barang::find($id);
		if($data != null){
			$data->update([
				'barang_deleted_at' => DB::raw("now"),
				'barang_deleted_by' => Auth::user()->getAuthIdentifier()
			]);

			$respon['success'] = true;
			$respon['state_code'] = 200;
			array_push($respon['messages'],'Barang berhasil dihapus.');
		} else {
			$respon['state_code'] = 500;
			array_push($respon['messages'],'Kesalahan! Barang tidak ditemukan.');
		}

    return response()->json($respon, $respon['state_code']);
	}
}
