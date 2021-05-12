<?php

namespace App\Tests\Unit\Delivery\Domain\Processor;

use App\Delivery\Domain\Exception\DeliveryDataNotFoundException;
use App\Delivery\Domain\Processor\DeliveryProcessor;
use App\History\Domain\Model\History;
use App\History\Domain\Model\HistoryRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DeliveryProcessorTest extends WebTestCase
{
    public function testGetDeliveryDaysByZipCode()
    {
        $expectedResult = 4;
        $zipCode = [History::ZIP_CODE => 1001];
        $historyRepository = $this->createMock(HistoryRepositoryInterface::class);
        $historyRepository->expects($this->once())
            ->method('findBy')
            ->with($zipCode)
            ->willReturn($this->getHistoryData());

        $deliveryProcessor = new DeliveryProcessor();
        $deliveryProcessor->setHistoryRepository($historyRepository);
        $this->assertEquals($expectedResult, $deliveryProcessor->getDeliveryDays(1001));
    }

    public function testGetDeliveryDaysByZipCodeAndRange()
    {
        $expectedResult = 4;
        $zipCode = 1001;
        $range = [
            'start_date' => '2020-01-10',
            'end_date' => '2020-01-15',
            ];
        $historyRepository = $this->createMock(HistoryRepositoryInterface::class);
        $historyRepository->expects($this->once())
            ->method('getDeliveryIntervals')
            ->with($zipCode, $range)
            ->willReturn($this->getHistoryData());

        $deliveryProcessor = new DeliveryProcessor();
        $deliveryProcessor->setHistoryRepository($historyRepository);
        $this->assertEquals($expectedResult, $deliveryProcessor->getDeliveryDays($zipCode, $range));

    }

    public function testException()
    {
        $this->expectException(DeliveryDataNotFoundException::class);
        $zipCode = [History::ZIP_CODE => 1001];
        $historyRepository = $this->createMock(HistoryRepositoryInterface::class);
        $historyRepository->expects($this->once())
            ->method('findBy')
            ->with($zipCode)
            ->willReturn([]);

        $deliveryProcessor = new DeliveryProcessor();
        $deliveryProcessor->setHistoryRepository($historyRepository);
        $deliveryProcessor->getDeliveryDays(1001);
    }

    private function getHistoryData()
    {
        $history1 = new History();
        $history1->setDeliveredDate(new \DateTime('2020-01-13'));
        $history1->setZipCode(1001);
        $history1->setOrderDate(new \DateTime('2020-01-09'));
        $history1->setShipmentDate(new \DateTime('2020-01-10'));

        $history2 = new History();
        $history2->setDeliveredDate(new \DateTime('2020-01-15'));
        $history2->setZipCode(1001);
        $history2->setOrderDate(new \DateTime('2020-01-10'));
        $history2->setShipmentDate(new \DateTime('2020-01-11'));

        return [$history1, $history2];
    }

}
