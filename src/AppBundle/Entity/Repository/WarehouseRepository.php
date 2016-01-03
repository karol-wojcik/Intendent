<?php
namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class WarehouseRepository extends EntityRepository
{
	public function getDefault()
	{
		return $this->getEntityManager()
			->createQuery('
				SELECT w FROM AppBundle:Warehouse w
				WHERE w.isDefault = true'
			)
			->getOneOrNullResult();
	}

	public function findAllOrderedByName()
	{
		return $this->getEntityManager()
			->createQuery(
				'SELECT w FROM AppBundle:Warehouse w ORDER BY w.name ASC'
			)
			->getResult();
	}
}