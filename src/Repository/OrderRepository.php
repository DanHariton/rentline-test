<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Order;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Order>
 */
final class OrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

    /**
     * @param array<string, string> $filters Example: ['status' => 'ACT', 'customerOrderNumber' => '32132133']
     * @param array<string, 'ASC'|'DESC'> $sort Example: ['orderNumber' => 'ASC'] or ['requestedDeliveryAt' => 'DESC']
     *
     * @return Order[]
     */
    public function findAllWithFilters(array $filters = [], array $sort = []): array
    {
        $qb = $this->createQueryBuilder('o')
            ->leftJoin('o.customer', 'c')->addSelect('c')
            ->leftJoin('o.contract', 'co')->addSelect('co')
            ->leftJoin('o.statuses', 's')->addSelect('s')
            ->leftJoin('s.user', 'u')->addSelect('u');

        if (! empty($filters['status'])) {
            $qb->andWhere('s.code = :status')
                ->setParameter('status', $filters['status']);
        }

        if (! empty($filters['customerOrderNumber'])) {
            $qb->andWhere('o.customerOrderNumber = :custNum')
                ->setParameter('custNum', $filters['customerOrderNumber']);
        }

        foreach ($sort as $field => $direction) {
            if (in_array($field, ['orderNumber', 'customerOrderNumber', 'requestedDeliveryAt', 'created', 'closedAt'], true)) {
                $qb->addOrderBy("o.$field", $direction === 'DESC' ? 'DESC' : 'ASC');
            }
        }

        return $qb->getQuery()->getResult();
    }
}
