<?php

/**
 * The movement class for inventoryText
 *
 * This class will monitor the movement of products in and
 * out of the inventory as well as the movement within inventory
 *
 * @author Christopher Collopy <ccollopy@cnm.edu>
 **/
class Movement {
	/**
	 * id for this Movement; this is the primary key
	 * @var int $movementId
	 **/
	private $movementId;

	/**
	 * id for the product's current location; this is a foreign key
	 * @var int $fromLocationId
	 **/
	private $fromLocationId;

	/**
	 * id for the product's new location; this is a foreign key
	 * @var int $toLocationId
	 **/
	private $toLocationId;

	/**
	 * id for the product being moved; this is a foreign key
	 * @var int $productId
	 **/
	private $productId;

	/**
	 * id for the units being moved; this is a foreign key
	 * @var int $unitId
	 **/
	private $unitId;

	/**
	 * cost of the product being moved
	 * @var double $cost
	 **/
	private $cost;

	/**
	 * the date of the movement
	 * @var string $movementDate
	 **/
	private $movementDate;

	/**
	 * the type of the movement;
	 * - M for Move
	 * - S for Sold
	 * - T for Trashed
	 * @var string $movementType
	 **/
	private $movementType;

	/**
	 * price of the product being moved
	 * @var double $price
	 **/
	private $price;

	/**
	 * accessor method for movementId
	 *
	 * @return int value of movementId
	 **/
	public function getMovementId() {
		return $this->movementId;
	}

	/**
	 * mutator method for movementId
	 *
	 * @param int $movementId
	 **/
	public function setMovementId($movementId) {
		$this->movementId = $movementId;
	}

	/**
	 * accessor method for fromLocationId
	 *
	 * @return int value of fromLocationId
	 */
	public function getFromLocationId() {
		return $this->fromLocationId;
	}

	/**
	 * mutator method for fromLocationId
	 *
	 * @param int $fromLocationId
	 */
	public function setFromLocationId($fromLocationId) {
		$this->fromLocationId = $fromLocationId;
	}

	/**
	 * accessor method for toLocationId
	 *
	 * @return int value of toLocationId
	 **/
	public function getToLocationId() {
		return $this->toLocationId;
	}

	/**
	 * mutator method for toLocationId
	 *
	 * @param int $toLocationId
	 **/
	public function setToLocationId($toLocationId) {
		$this->toLocationId = $toLocationId;
	}

	/**
	 * accessor method for productId
	 *
	 * @return int value of productId
	 **/
	public function getProductId() {
		return $this->productId;
	}

	/**
	 * mutator method for productId
	 *
	 * @param int $productId
	 **/
	public function setProductId($productId) {
		$this->productId = $productId;
	}

	/**
	 * accessor method for unitId
	 *
	 * @return int value of unitId
	 */
	public function getUnitId() {
		return $this->unitId;
	}

	/**
	 * mutator method for unitId
	 *
	 * @param int $unitId
	 */
	public function setUnitId($unitId) {
		$this->unitId = $unitId;
	}

	/**
	 * accessor method for cost
	 *
	 * @return float value of cost
	 */
	public function getCost() {
		return $this->cost;
	}

	/**
	 * mutator method for cost
	 *
	 * @param float $cost
	 */
	public function setCost($cost) {
		$this->cost = $cost;
	}

	/**
	 * accessor method for movementDate
	 *
	 * @return string value of movementId
	 */
	public function getMovementDate() {
		return $this->movementDate;
	}

	/**
	 * mutator method for movementDate
	 *
	 * @param string $movementDate
	 */
	public function setMovementDate($movementDate) {
		$this->movementDate = $movementDate;
	}

	/**
	 * accessor method for movementType
	 *
	 * @return string value of movementType
	 */
	public function getMovementType() {
		return $this->movementType;
	}

	/**
	 * mutator method for movementType
	 *
	 * @param string $movementType
	 */
	public function setMovementType($movementType) {
		$this->movementType = $movementType;
	}

	/**
	 * accessor method for price
	 *
	 * @return float value of price
	 */
	public function getPrice() {
		return $this->price;
	}

	/**
	 * mutator method for price
	 *
	 * @param float $price
	 */
	public function setPrice($price) {
		$this->price = $price;
	}
}