<?php

namespace App\History\Domain\Adapter;

class RangeBuilder
{
    const START_DATE = 'start_date';
    const END_DATE = 'end_date';

    /**
     * @param array $range
     * @return array
     */
    public static function buildRangeDate(array $range): array
    {
        if (isset($range[self::START_DATE]) && !isset($range[self::END_DATE])) {
            if (self::isDateTheFirstOfMonth($range[self::START_DATE])) {
                return self::getMonthRange($range[self::START_DATE]);
            } else {
                return self::getDefaultDate($range[self::START_DATE]);
            }
        }
        return $range;
    }

    /**
     * @param $startDate
     * @return bool
     */
    private static function isDateTheFirstOfMonth($startDate): bool
    {
        $date = new \DateTime($startDate);
        return $date->format('Y-m-d') == $date->format('Y-m-01');
    }

    /**
     * @param string $date
     * @return array
     */
    private static function getMonthRange(string $date): array
    {
        $date = new \DateTime($date);
        $date->modify('-1 month');
        $startDate = $date->modify('first day of this month');
        $endDate = clone $startDate;
        $range[self::START_DATE] = $startDate;
        $range[self::END_DATE] = $endDate->modify('last day of this month');

        return $range;
    }

    /**
     * @param string $date
     * @return array
     */
    private static function getDefaultDate(string $date): array
    {
        $endDate = new \DateTime($date);
        $startDate = clone $endDate;
        $range[self::END_DATE] = $endDate;
        $range[self::START_DATE] = $startDate->modify('-10 day');

        return $range;
    }
}
