<?php

namespace App\Model;

/*
 * Product Model
 */
class Product
{
	protected $id, $name, $unit, $createdAt;

	/*
	 * Set Product Id
	 * 
	 * @param integer $id
	 * @return Product
	 */
	public function setId($id)
	{
		$this->id = $id;

		return $this;
	}
	
	/*
	 * Get Product Id
	 * 
	 * @return integer
	 */
	public function getId()
	{
		return $this->id;
	}

	/*
	 * Set Product Name
	 * 
	 * @param string $name
	 * @return Product
	 */
	public function setName(string $name)
	{
		$this->name = $name;

		return $this;
	}

	/*
	 * Set Product Name
	 * 
	 * @param string $name
	 * @return Product
	 */
	public function getName()
	{
		return $this->name;
	}

	/*
	 * Set Product Unit
	 * 
	 * @param string $unit
	 * @return Product
	 */
	public function setUnit(string $unit)
	{
		$this->unit = $unit;

		return $this;
	}

	/*
	 * Get Product Unit
	 * 
	 * @return string
	 */
	public function getUnit()
	{
		return $this->unit;
	}

	/*
	 * Set Product Unit
	 * 
	 * @param string $name
	 * @return Product
	 */
	public function setCreatedAt(string $createdAt)
	{
		$this->createdAt = $createdAt;

		return $this;
	}

	/*
	 * Get Product Created At
	 * 
	 * @return DateTime
	 */
	public function getCreatedAt()
	{
		return $this->createdAt;
	}
}