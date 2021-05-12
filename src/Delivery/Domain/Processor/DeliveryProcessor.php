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
        try {
            if (empty($range)) {
                $results = $this->historyRepository->findBy([History::ZIP_CODE => $zipCode]);
            }
            $results = $this->historyRepository->getDeliveryIntervals($zipCode , $range);
        } catch (DeliveryDataNotFoundException $exception) {
            $this->logger->error(
                'DeliveryDataNotFoundException',
                ['zip_code' => $zipCode, 'range' => $range]
            );
        }
        $count = count($results);
        foreach ($results as $result) {
            $deliveryDate = $result->getDeliveredDate();
            $shipmentDate = $result->getShipmentDate();
            $diff = $deliveryDate->diff($shipmentDate);
            $deliveryInterval[] = $diff->format("%a");
        }

        $days = array_sum($deliveryInterval) / $count;
        return (int) $days;
    }
}
