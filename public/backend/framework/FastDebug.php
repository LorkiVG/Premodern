<?php

function debug ($str) {
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