<?php

namespace App\History\Domain\Model;

interface HistoryRepositoryInterface
{
    /**
     * @param int $zipCode
     * @param array $range
     * @return array
     */
    public function getDeliveryIntervals(int $zipCode, array $range): array;

    /**
     * @param array $criteria
     * @param array|null $orderBy
     * @param null $limit
     * @param null $offset
     * @return array
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null): array;
}
