<?php
/**
 * Created by PhpStorm.
 * User: Karol
 * Date: 2016-01-02
 * Time: 18:10
 */

namespace AppBundle\Entity;


class OperationElement
{
	protected $id;
	protected $operation;
	protected $product;
	protected $basePrice;
	protected $quantity;
	protected $value;

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
	public function getOperation()
	{
		return $this->operation;
	}

	/**
	 * @param mixed $operation
	 * @return $this
	 */
	public function setOperation($operation)
	{
		$this->operation = $operation;
		return $this;
	}

	/**
	 * @return Product
	 */
	public function getProduct()
	{
		return $this->product;
	}

	/**
	 * @param mixed $product
	 * @return $this
	 */
	public function setProduct($product)
	{
		$this->product = $product;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getBasePrice()
	{
		return $this->basePrice;
	}

	/**
	 * @param mixed $basePrice
	 * @return $this
	 */
	public function setBasePrice($basePrice)
	{
		$this->basePrice = $basePrice;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getQuantity()
	{
		return $this->quantity;
	}

	/**
	 * @param mixed $quantity
	 * @return $this
	 */
	public function setQuantity($quantity)
	{
		$this->quantity = $quantity;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getValue()
	{
		return $this->value;
	}

	/**
	 * @param mixed $value
	 * @return $this
	 */
	public function setValue($value)
	{
		$this->value = $value;
		return $this;
	}
}