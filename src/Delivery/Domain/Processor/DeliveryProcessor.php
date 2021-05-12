<?php

namespace App\Delivery\Domain\Processor;

use App\History\Domain\Model\History;
use App\History\Domain\Model\HistoryRepositoryInterface;
use Psr\Log\LoggerInterface;
use App\Delivery\Domain\Exception\DeliveryDataNotFoundException;

class DeliveryProcessor
{
    private HistoryRepositoryInterface $historyRepository;
    private LoggerInterface $logger;

    /**
     * @param LoggerInterface $logger
     * @required
     */
    public function setLogger(LoggerInterface $logger): void
    {
        $this->logger = $logger;
    }

    /**
     * @param HistoryRepositoryInterface $historyRepository
     * @required
     */
    public function setHistoryRepository(HistoryRepositoryInterface $historyRepository): void
    {
        $this->historyRepository = $historyRepository;
    }

    /**
     * @param int $zipCode
     * @param array|null $range
     * @return int
     */
    public function getDeliveryDays(int $zipCode, array $range = null): int
    {
        $deliveryInterval = [];
        if (empty($range)) {
            $results = $this->historyRepository->findBy([History::ZIP_CODE => $zipCode]);
        } else {
            $results = $this->historyRepository->getDeliveryIntervals($zipCode , $range);
        }
        if (null == $results) {
            throw new DeliveryDataNotFoundException("No history data found.");
        }
        $count = count($results);
        foreach ($results as $result) {
            $deliveryDate = $result->getDeliveredDate();
            $shipmentDate = $result->getShipmentDate();
            $diff = $deliveryDate->diff($shipmentDate);
            $deliveryInterval[] = $diff->format("%a");
        }

        $days = array_sum($deliveryInterval) / $count;
        return round($days);
    }
}
