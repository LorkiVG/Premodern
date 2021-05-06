<?php 

namespace backend\framework;




class DevTolls
{
  public static function Debug ($str) {
    
    if (SettingsLoader::SettingLoader('DEBUG_MODE') and SettingsLoader::SettingLoader('DEV_TOLLS')) {
      $type = gettype($str);
      if ($type == 'array') {
        echo '<pre>';
        var_dump($str);
        echo '</pre>';
      } elseif ($type == 'object') {
        echo '<pre>';
        var_dump($str);
        echo '</pre>';
      }elseif ($type == ('string' || 'integer' || 'double')) {
        echo $str;
      }elseif ($type == 'bollean') {
        if ($str == true) {
          echo 'True';
        } else {
          echo 'False';
        }
      }elseif ($type == 'null') {
        echo 'NULL';
      } else {
        echo 'Variable type impossimble undebuging';
      }
    }
    
  }


  public static function DebugArray ($str) {
    if (SettingsLoader::SettingLoader('DEBUG_MODE') and SettingsLoader::SettingLoader('DEV_TOLLS')) {
      echo '<pre>';
      var_dump($str);
      echo '</pre>';
    }
    
  }

  public static function DebugObject ($str) {
    if (SettingsLoader::SettingLoader('DEBUG_MODE') and SettingsLoader::SettingLoader('DEV_TOLLS')) {
      echo '<pre>';
      var_dump($str);
      echo '</pre>';
    }
    
  }
}
