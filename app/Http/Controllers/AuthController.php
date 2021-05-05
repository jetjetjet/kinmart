<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Hash;
use DB;
use Validator;

use App\Models\User;
use App\Helpers\Utils;

class AuthController extends Controller
{
  public function login(Request $request)
  {
    $respon = Utils::$responses;
    $rules = array(
      'username' => 'required',
      'password' => 'required',
    );
    $inputs = $request->all();
    $respon['data'] = Array("username" => $inputs['username']);
    
    $validator = Validator::make($inputs, $rules);
    if ($validator->fails()){
      $respon['messages'] = $validator->errors()->all();
      return response()->json($respon, $respon['state_code']);
    }

    $attr = Array(
      'username'=> $inputs['username'], 
      'password' => $inputs['password'],
      'user_active' => '1'
    );

    if(!Auth::attempt($attr)){
      array_push($respon['messages'],'Username/Password anda salah atau tidak terdaftar');
      return response()->json($respon, $respon['state_code']);
    }
    
    $token = Auth::user()->createToken($request->username);
    $data = Array( "token" => $token->plainTextToken,
      "userid" => Auth::user()->id,
      "username" => Auth::user()->username,
      "nama_lengkap" => Auth::user()->nama_lengkap,
      "perms" => Auth::user()->getPerms()
    );

    $respon['success'] = true;
    $respon['state_code'] = 200;
    $respon['data'] = $data;
    
    // $idUser = $user->id ?? 0;
    // $audit = AuditTrailRepository::saveAuditTrail($request, $respon, 'Login', $idUser);

    return response()->json($respon, $respon['state_code']);
  }

  public function logout(Request $request)
  {
    // //$user = User::where('email', Auth::user()->getEmail())->first();
    // $user = request()->user();
    // $idUser = $user->id ?? 0;
    // $respon = Utils::$responses;
    // $respon['success'] = true;
    // // $audit = AuditTrailRepository::saveAuditTrail($request, $respon, 'Logout', $idUser);
    // // $user->tokens()->where('name', $user->nip)->delete();
    // $user->currentAccessToken()->delete();
    auth()->user()->tokens()->delete();
    return response()->json(['success' => true], 200);
  }
}
