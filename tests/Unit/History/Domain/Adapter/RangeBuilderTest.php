<?php

namespace App\Tests\Unit\History\Domain\Adapter;

use App\History\Domain\Adapter\RangeBuilder;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RangeBuilderTest extends WebTestCase
{
    public function testWithCompleteRange()
    {
        $range = [
            'start_date' => '2021-05-01',
            'end_date' => '2021-05-02',
        ];

        $expected = [
            'start_date' => '2021-05-01',
            'end_date' => '2021-05-02',
        ];
        $this->assertEquals($expected, RangeBuilder::buildRangeDate($range));
    }

    public function testRetrievePastMonth()
    {
        $range = [
            'start_date' => '2021-05-01',
        ];

        $expected = [
            'start_date' => new \DateTime('2021-04-01'),
            'end_date' => new \DateTime('2021-04-30'),
        ];
        $this->assertEquals($expected, RangeBuilder::buildRangeDate($range));
    }

    public function testDefaultRange()
    {
        $range = [
            'start_date' => '2021-05-15',
        ];

        $expected = [
            'start_date' => new \DateTime('2021-05-05'),
            'end_date' => new \DateTime('2021-05-15'),
        ];
        $this->assertEquals($expected, RangeBuilder::buildRangeDate($range));
    }
}
