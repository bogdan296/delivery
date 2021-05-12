<?php

namespace App\Tests\Unit\Delivery\Domain\Validator;

use App\Delivery\Domain\Validator\DayValidator;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DayValidatorTest extends WebTestCase
{
    public function testWorkingDay()
    {
        $date = new \DateTime('2021-05-07');
        $this->assertTrue(DayValidator::isWorkingDay($date));
    }

    public function testWeekendDay()
    {
        $date = new \DateTime('2021-05-08');
        $this->assertFalse(DayValidator::isWorkingDay($date));
    }

    public function testHolidayDay()
    {
        $date = new \DateTime('2021-12-25');
        $this->assertFalse(DayValidator::isWorkingDay($date));
    }

}
