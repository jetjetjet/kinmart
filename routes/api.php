<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\SuppliersController;
use App\Http\Controllers\KategoriBarangController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => 'auth:sanctum'], function() {
  Route::get('/me', function(Request $request) {
    return auth()->user();
  });

  Route::get('jabatan/semua', [JabatanController::class, 'getAll']);
  Route::get('jabatan/detail/{id}', [JabatanController::class, 'getById']);
  Route::post('jabatan/simpan', [JabatanController::class, 'save']);
  Route::post('jabatan/hapus/{id}', [JabatanController::class, 'delete']);

  Route::get('supplier/semua', [SuppliersController::class, 'getAll']);
  Route::get('supplier/detail/{id}', [SuppliersController::class, 'getById']);
  Route::post('supplier/simpan', [SuppliersController::class, 'save']);
  Route::post('supplier/hapus/{id}', [SuppliersController::class, 'delete']);

  Route::get('kategori_barang/semua', [KategoriBarangController::class, 'getAll']);
  Route::get('kategori_barang/detail/{id}', [KategoriBarangController::class, 'getById']);
  Route::post('kategori_barang/simpan', [KategoriBarangController::class, 'save']);
  Route::post('kategori_barang/hapus/{id}', [KategoriBarangController::class, 'delete']);

  Route::post('/logout', [AuthController::class, 'logout']);
});
