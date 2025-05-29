<?php

namespace App\Helpers;

class DateHelper
{
    public static function getWorkdays($date1, $date2, $workSat = false, $patron = null)
    {
        if (!defined('SATURDAY')) define('SATURDAY', 6);
        if (!defined('SUNDAY')) define('SUNDAY', 0);

        // Array of all public holidays (MM-DD)
        $publicHolidays = [
            '01-01', // New Year's Day
            '01-27', // Isra'Mi'raj
            '01-29', // Imlek
            '03-29', // Nyepi
            '03-31', // Idul Fitri
            '04-01', // Idul Fitri
            '04-18', // Jumat Agung
            '05-01', // Labor Day
            '05-12', // Isa Al Masih
            '05-29', // Waisak
            '06-01', // Pancasila
            '06-07', // Idul Adha
            '06-27', // Hijriyah
            '08-17', // HUT RI
            '09-05', // Maulid Nabi
            '12-25', // Christmas
        ];

        // Add patron saint day (MM-DD format)
        if ($patron) {
            $publicHolidays[] = $patron;
        }

        // Calculate all Easter Mondays in the year range
        $yearStart = date('Y', strtotime($date1));
        $yearEnd   = date('Y', strtotime($date2));
        $easterMondays = [];

        for ($i = $yearStart; $i <= $yearEnd; $i++) {
            $easter = date('Y-m-d', easter_date($i));
            list($y, $m, $d) = explode("-", $easter);
            $monday = mktime(0, 0, 0, $m, $d + 1, $y);
            $easterMondays[] = $monday;
        }

        $start = strtotime($date1);
        $end   = strtotime($date2);
        $workdays = 0;

        for ($i = $start; $i <= $end; $i = strtotime("+1 day", $i)) {
            $day = date("w", $i);  // 0 = Sunday, ..., 6 = Saturday
            $mmdd = date('m-d', $i);

            if (
                $day != SUNDAY &&
                !in_array($mmdd, $publicHolidays) &&
                !in_array($i, $easterMondays) &&
                !($day == SATURDAY && $workSat == false)
            ) {
                $workdays++;
            }
        }

        return $workdays;
    }
}
