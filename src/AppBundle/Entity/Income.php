<?php
/**
 * Created by PhpStorm.
 * User: Karol
 * Date: 2015-12-30
 * Time: 16:48
 */

namespace AppBundle\Entity;


use Doctrine\Common\Collections\ArrayCollection;

class Income
{
	protected $id;
	protected $externalId;
	protected $incomeDate;
	protected $warehouse;
	protected $operator;
	protected $contractor;
	protected $elements;
	protected $totalAmount;
	protected $createdAt;
	protected $updatedAt;

	/**
	 * Operation constructor.
	 */
	public function __construct()
	{
		$this->elements = new ArrayCollection();
        $this->totalAmount = 0;
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
	public function getExternalId()
	{
		return $this->externalId;
	}

	/**
	 * @param mixed $externalId
	 * @return $this
	 */
	public function setExternalId($externalId)
	{
		$this->externalId = $externalId;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getCreatedAt()
	{
		return $this->createdAt;
	}

	/**
	 * @param mixed $createdAt
	 * @return $this
	 */
	public function setCreatedAt($createdAt)
	{
		$this->createdAt = $createdAt;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getUpdatedAt()
	{
		return $this->updatedAt;
	}

	/**
	 * @param mixed $updatedAt
	 * @return $this
	 */
	public function setUpdatedAt($updatedAt)
	{
		$this->updatedAt = $updatedAt;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getWarehouse()
	{
		return $this->warehouse;
	}

	/**
	 * @param mixed $warehouse
	 * @return $this
	 */
	public function setWarehouse($warehouse)
	{
		$this->warehouse = $warehouse;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getOperator()
	{
		return $this->operator;
	}

	/**
	 * @param mixed $operator
	 * @return $this
	 */
	public function setOperator($operator)
	{
		$this->operator = $operator;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getContractor()
	{
		return $this->contractor;
	}

	/**
	 * @param mixed $contractor
	 * @return $this
	 */
	public function setContractor($contractor)
	{
		$this->contractor = $contractor;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getIncomeDate()
	{
		return $this->incomeDate;
	}

	/**
	 * @param mixed $incomeDate
	 * @return $this
	 */
	public function setIncomeDate($incomeDate)
	{
		$this->incomeDate = $incomeDate;
		return $this;
	}

	/**
	 * @return ArrayCollection
	 */
	public function getElements()
	{
		return $this->elements;
	}

	/**
	 * @param ArrayCollection $elements
	 * @return $this
	 */
	public function setElements($elements)
	{
		$this->elements = $elements;
		return $this;
	}

    /**
     * @return int
     */
    public function getTotalAmount()
    {
        return $this->totalAmount;
    }

    /**
     * @param int $totalAmount
     * @return $this
     */
    public function setTotalAmount($totalAmount)
    {
        $this->totalAmount = $totalAmount;
        return $this;
    }

    public function addElement(IncomeElement $element)
    {
        $this->elements->add($element);
    }

    public function removeElement(IncomeElement $element)
    {
        $this->elements->removeElement($element);
    }

	public function updatedTimestamps()
	{
		$this->setUpdatedAt(new \DateTime('now'));

		if ($this->getCreatedAt() == null) {
			$this->setCreatedAt(new \DateTime('now'));
		}
	}
}