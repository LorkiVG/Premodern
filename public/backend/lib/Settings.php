<?php 

namespace backend\lib;

class Settings
{
  public static function Loader($value)
  {
    require 'backend/settings/settings.php';
    
    $setting = $settings[$value];
    return $setting;
  }
}


?>