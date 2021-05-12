<?php

namespace App\History\Domain\Model;

interface HistoryRepositoryInterface
{
    /**
     * @param int $zipCode
     * @param array $range
     * @return array|null
     */
    public function getDeliveryIntervals(int $zipCode, array $range): ?array;

    /**
     * @param array $criteria
     * @param array|null $orderBy
     * @param null $limit
     * @param null $offset
     * @return array|null
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null): ?array;
}
