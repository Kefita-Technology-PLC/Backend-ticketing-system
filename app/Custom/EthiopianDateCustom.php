<?php

namespace App\Custom;
use Andegna\DateTimeFactory;

class EthiopianDateCustom{
  public static function input($date){
    list($year, $month, $day) = explode('-', $date);

    $ethiopianDate = DateTimeFactory::of((int)$year, (int)$month, (int)$day);

    $gregorianDate = $ethiopianDate->toGregorian();

    $gregorianDateString = $gregorianDate->format('Y-m-d');

    return $gregorianDateString;
  }

  public static function toEthiopian(){
    
  }

}