<?php

namespace App\Traits;

use DateTime;
use Carbon\Carbon;

trait DateTrait
{
    function getWeekNumber($date)
    {
        $date = new DateTime($date);
        $weekNumber = $date->format('W');

        // Adjust the week number if the first day of the week is not Monday
        if ($date->format('N') <= 4) {
            $weekNumber++;
        }

        return $weekNumber;
    }
    

}