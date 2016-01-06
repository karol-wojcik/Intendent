<?php
namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class ProductStockRepository extends EntityRepository
{
    public function findCurrentForProduct($productId)
    {
        return $this->getEntityManager()
            ->createQuery('
              SELECT p FROM AppBundle:ProductStock p
              WHERE p.id = :product_id
              ORDER BY p.stockDate DESC'
            )
            ->setParameter('product_id', $productId)
            ->setMaxResults(1)
            ->getOneOrNullResult();
    }

    public function findCurrentForAll()
    {
        return $this->getEntityManager()
            ->createQuery('
              SELECT ps, pp FROM AppBundle:ProductStock ps
              LEFT JOIN AppBundle:ProductStock ps2
                WITH ps1.product_id = ps2.product_id AND ps2.stockDate > ps1.stockDate
              WHERE ps2.stockDate IS NULL
              JOIN p.product pp
              ORDER BY pp.name ASC'
            )
            ->getResult();
    }

    public function findCurrentForMany($productIds)
    {
        return $this->getEntityManager()
            ->createQuery('
              SELECT ps1, p FROM AppBundle:ProductStock ps1
              INDEX BY ps1.id
              LEFT JOIN AppBundle:ProductStock ps2
                WITH ps1.product = ps2.product AND ps2.stockDate > ps1.stockDate
              JOIN ps1.product p
              WHERE ps2.stockDate IS NULL
                AND ps1.product IN (:ids)
              ORDER BY p.name ASC'
            )
            ->setParameter('ids', $productIds)
            ->getResult();
    }
}