<?php

namespace App\DataFixtures\Infrastructure\Fixtures;

use App\Delivery\Domain\Validator\DayValidator;
use App\History\Domain\Model\History;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use DateTime;

class AppFixtures extends Fixture
{
    const DELIVERY_MIN_DAYS = 3;
    const DELIVERY_MAX_DAYS = 14;

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 5000; $i++) {
            $startDate = new \DateTime('2020-01-01');
            $endDate = new \DateTime('2020-12-31');
            $history = new History();
            $history->setZipCode($this->generateZipCode());
            $history->setOrderDate($this->generateOrderDate($startDate, $endDate));
            $history->setShipmentDate($this->generateShipmentDate(clone $history->getOrderDate()));
            $history->setDeliveredDate($this->generateDeliveryDate(clone $history->getShipmentDate()));
            $manager->persist($history);
        }

        $manager->flush();
    }

    /**
     * @param \DateTime $start
     * @param \DateTime $end
     * @return \DateTime
     */
    private function generateOrderDate(\DateTime $start, \DateTime $end): \DateTime
    {
        $randomTimestamp = mt_rand($start->getTimestamp(), $end->getTimestamp());
        $randomDate = new DateTime();
        $randomDate->setTimestamp($randomTimestamp);
        return $randomDate;
    }

    /**
     * @return int
     */
    private function generateZipCode(): int
    {
        return mt_rand(1000, 1010);
    }

    /**
     * @param \DateTime $orderDate
     * @return \DateTime
     */
    private function generateShipmentDate(\DateTime $orderDate): \DateTime
    {
        $shipmentDay = $orderDate->modify('+1 day');
        if (!DayValidator::isWorkingDay($shipmentDay)) {
            $this->generateShipmentDate($shipmentDay);
        }
        return $shipmentDay;
    }

    /**
     * @param \DateTime $shipmentDate
     * @return \DateTime
     */
    private function generateDeliveryDate(\DateTime $shipmentDate): \DateTime
    {
        $interval = mt_rand(self::DELIVERY_MIN_DAYS,self::DELIVERY_MAX_DAYS);
        $deliveryDate = $shipmentDate->modify( '+'.$interval.' day');

        $deliveryDateDiff = $deliveryDate->diff($shipmentDate);
        $deliveryDateInterval = $deliveryDateDiff->format("%a");

        if (!DayValidator::isWorkingDay($deliveryDate) ||
            $deliveryDateInterval < self::DELIVERY_MIN_DAYS ||
            $deliveryDateInterval > self::DELIVERY_MAX_DAYS ) {
            $this->generateShipmentDate($deliveryDate);
        }
        return $deliveryDate;
    }
}
