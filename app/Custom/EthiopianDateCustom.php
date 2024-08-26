<?php

namespace App\Custom;
use Andegna\DateTimeFactory;

class EthiopianDateCustom{
  public static function input($date) {
    // Check if the date format is YYYY-MM-DD using regex
    // if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
    //     throw new \InvalidArgumentException('Invalid date format. Expected format is YYYY-MM-DD.');
    // }

    // Split the date into components
    $dateParts = explode('-', $date);

    // dd($date);
    // Check if the resulting array has exactly three elements

    // dd(count($dateParts));
    if (count($dateParts) !== 3) {
        throw new \InvalidArgumentException('Invalid date format. Expected format is YYYY-MM-DD.');
    }

    // Assign the parts to year, month, and day
    // list($year, $month, $day) = $dateParts;

    // Continue with the conversion
    try {
        $ethiopianDate = DateTimeFactory::of((int)$dateParts[0], (int)$dateParts[1], (int)$dateParts[2]);
        $gregorianDate = $ethiopianDate->toGregorian();
        $gregorianDateString = $gregorianDate->format('Y-m-d');
    } catch (\Exception $e) {
        throw new \InvalidArgumentException('Invalid Ethiopian date: ' . $e->getMessage());
    }

    return $gregorianDateString;
}



  public static function toEthiopian($date){

    list($year, $month, $day) = explode('-', $date);

    $gregorianDate = new \DateTime($date);
    
    // Create an Ethiopian date from the Gregorian date
    $ethiopianDate = DateTimeFactory::fromDateTime($gregorianDate);

    $ethiopianDateString = $ethiopianDate->format('Y-m-d');

    return $ethiopianDateString;
  }

}