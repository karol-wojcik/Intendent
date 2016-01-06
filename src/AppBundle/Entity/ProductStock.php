<?php
/**
 * Created by PhpStorm.
 * User: Karol
 * Date: 2015-12-30
 * Time: 16:48
 */

namespace AppBundle\Entity;


class ProductStock
{
	protected $id;
	protected $stock;
	protected $stockDate;
	protected $product;
	protected $operation;

    /**
     * ProductStock constructor.
     */
    public function __construct()
    {
        $this->stockDate = new \DateTime('now');
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
	public function getStock()
	{
		return $this->stock;
	}

	/**
	 * @param mixed $stock
	 * @return $this
	 */
	public function setStock($stock)
	{
		$this->stock = $stock;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getStockDate()
	{
		return $this->stockDate;
	}

	/**
	 * @param mixed $stockDate
	 * @return $this
	 */
	public function setStockDate($stockDate)
	{
		$this->stockDate = $stockDate;
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
}