<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Model\User;

use DB;

class HakAkses
{
  public static $all = array(
    'auditTrail_list',

    'jabatan_lihat',
    'jabatan_simpan',
    'jabatan_hapus',
    'jabatan_HakAkses'
  );

  public static function all()
  {
    $result = array();
    foreach (self::$all as $value){
      $values = explode('_', $value);
      if (!isset($result[$values[0]])){
        $result[$values[0]] = new \stdClass();
        $result[$values[0]]->module = $values[0];
        $result[$values[0]]->actions = array();
      }
      
      $action = new \stdClass();
      $action->value = $value;
      $action->text = $values[1];
      array_push($result[$values[0]]->actions, $action);
    }
    ksort($result);
    return $result;
  }

  public static function arrAll()
  {
    $perms = self::all();
    $result = array();
    foreach($perms as $val){
      array_push($result, $val);
    }
    return $result; 
  }
}