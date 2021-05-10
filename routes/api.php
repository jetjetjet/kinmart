<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MemberController;

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

  Route::get('member/semua', [MemberController::class, 'getAll']);
  Route::get('member/detail/{id}', [MemberController::class, 'getById']);
  Route::post('member/simpan', [MemberController::class, 'save']);
  Route::post('member/hapus/{id}', [MemberController::class, 'delete']);

  Route::get('user/semua', [UserController::class, 'getAll']);
  Route::get('user/detail/{id}', [UserController::class, 'getById']);
  Route::post('user/simpan', [UserController::class, 'save']);
  Route::post('user/hapus/{id}', [UserController::class, 'delete']);
  Route::post('user/password/{id}', [UserController::class, 'password']);

  Route::post('/logout', [AuthController::class, 'logout']);
});
