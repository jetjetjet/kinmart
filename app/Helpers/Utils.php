<?php
namespace App\Helpers;

class Utils
{
  public static $responses = array( 
    'state_code' => 400, 
    'success' => false, 
    'messages' => array(), 
    'data' => Array());

  public static function prepareFile($inputs, $subFolder)
  {
    $file = new \StdClass;
    try {
      $file = isset($inputs['file']) ? $inputs['file'] : null;
      $file->path = base_path() . $subFolder;
      $file->newName = time()."_".$file->getClientOriginalName();
      $file->originalName = explode('.',$file->getClientOriginalName())[0];
      $file->move($file->path ,$file->newName);
    } catch (Exception $e){
        // lanjut
    }
    return $file;
  }
}