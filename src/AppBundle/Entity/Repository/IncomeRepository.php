<?php
namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class IncomeRepository extends EntityRepository
{
	public function findAllByDate()
	{
        return $this->getEntityManager()
            ->createQuery('
                SELECT i, c FROM AppBundle:Income i
                JOIN i.contractor c
                ORDER BY i.incomeDate ASC'
            )
            ->getResult();
	}
}