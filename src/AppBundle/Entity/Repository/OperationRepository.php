<?php
namespace AppBundle\Entity\Repository;

use AppBundle\Entity\Operation;
use Doctrine\ORM\EntityRepository;

class OperationRepository extends EntityRepository
{
	public function findAllIncomeByDate()
	{
		return $this->getByType(Operation::TYPE_INCOME);
	}
	public function findAllOutcomeByDate()
	{
		return $this->getByType(Operation::TYPE_OUTCOME);
	}

	private function getByType($type)
	{
		return $this->getEntityManager()
				->createQuery('
				  	SELECT o, c FROM AppBundle:Operation o
				  	JOIN o.contractor c
					WHERE o.type = :type
 					ORDER BY o.operationDate ASC'
				)
				->setParameter('type', $type)
				->getResult();
	}
}