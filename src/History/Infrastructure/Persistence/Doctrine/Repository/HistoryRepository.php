<?php

namespace App\History\Infrastructure\Persistence\Doctrine\Repository;

use App\History\Domain\Adapter\RangeBuilder;
use App\History\Domain\Model\History;
use App\History\Domain\Model\HistoryRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;

class HistoryRepository extends ServiceEntityRepository implements HistoryRepositoryInterface
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, History::class);
    }

    /**
     * @param array $criteria
     * @param array|null $orderBy
     * @param null $limit
     * @param null $offset
     * @return array|null
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null): ?array
    {
        return parent::findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * @param int $zipCode
     * @param array $range
     * @return array|null
     */
    public function getDeliveryIntervals(int $zipCode, array $range): ?array
    {
        $range = RangeBuilder::buildRangeDate($range);
        $queryBuilder = $this->createQueryBuilder('d');
        $queryBuilder
            ->select('d')
            ->where('d.zipCode = :zipCode')
            ->andWhere('d.orderDate BETWEEN :min AND :max')
            ->setParameter('min', $range[RangeBuilder::START_DATE])
            ->setParameter('max', $range[RangeBuilder::END_DATE])
            ->setParameter('zipCode', $zipCode);
        return $queryBuilder->getQuery()->getResult();
    }
}
