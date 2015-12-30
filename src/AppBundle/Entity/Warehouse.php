<?php
/**
 * Created by PhpStorm.
 * User: Karol
 * Date: 2015-12-30
 * Time: 11:36
 */

namespace AppBundle\Entity;

class Warehouse
{
	protected $id;
	protected $name;
	protected $isDefault;

	/**
	 * Warehouse constructor.
	 */
	public function __construct()
	{
		$this->isDefault = false;
	}

	/**
	 * @return mixed
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param mixed $id
	 * @return $this
	 */
	public function setId($id)
	{
		$this->id = $id;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @param mixed $name
	 * @return $this
	 */
	public function setName($name)
	{
		$this->name = $name;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getIsDefault()
	{
		return $this->isDefault;
	}

	/**
	 * @param mixed $isDefault
	 * @return $this
	 */
	public function setIsDefault($isDefault)
	{
		$this->isDefault = $isDefault;
		return $this;
	}
}