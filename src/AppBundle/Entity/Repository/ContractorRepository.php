<?php
namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class ContractorRepository extends EntityRepository
{
	public function findAllOrderedByName()
	{
		return $this->getEntityManager()
			->createQuery(
				'SELECT c FROM AppBundle:Contractor c ORDER BY c.name ASC'
			)
			->getResult();
	}
}