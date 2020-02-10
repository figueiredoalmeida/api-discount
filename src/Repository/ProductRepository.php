<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function findCategory(string $id): ?int
    {
        $query = $this->createQueryBuilder('p')
            ->andWhere('p.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getArrayResult();

        return $query[0]['category'];
    }

    public function findCheapest(array $id): ?array
    {
        $query = $this->createQueryBuilder('p')
            ->andWhere('p.id IN (:string)')
            ->setParameter('string', $id)
            ->orderBy('p.price')
            ->setMaxResults(1)
            ->getQuery()
            ->getArrayResult();

        return $query;
    }
}
