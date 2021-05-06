<?php 
namespace backend\lib;
use DateTime;

class TimeManager 
{

  public static function validateDateFormat($date, $format = 'y.m.d-H:i:s')
  {
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
  }
}

?>