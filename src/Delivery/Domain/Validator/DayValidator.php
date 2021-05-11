<?php

namespace App\Delivery\Domain\Validator;

class DayValidator
{
    private static array $holidays = ['*-12-25', '*-01-01', '*-12-26'];

    /**
     * @param \DateTime $dateTime
     * @return bool
     */
    public static function isWorkingDay(\DateTime $dateTime): bool
    {
        if ($dateTime->format('N') >= 6) {
            return false;
        }
        if (in_array($dateTime->format('*-m-d'), self::$holidays)) {
            return false;
        }
        return true;
    }
}
