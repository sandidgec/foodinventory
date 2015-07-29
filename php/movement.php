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
	 * the type of the movement
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
	 * @param int $newMovementId id for this Movement
	 * @param int $newFromLocationId id for the product's current location
	 * @param int $newToLocationId id for the product's new location
	 * @param int $newProductId id for the product being moved
	 * @param int $newUnitId id for the units being moved
	 * @param double $newCost cost of the product being moved
	 * @param string $newMovementDate the date of the movement
	 * @param string$newMovementType the type of the movement
	 * @param double $newPrice price of the product being moved
	 * @throws InvalidArgumentException if data types are not valid
	 * @throws RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws Exception if some other exception is thrown
	 */

	public function __construct($newMovementId, $newFromLocationId, $newToLocationId, $newProductId,
										 $newUnitId, $newCost, $newMovementDate, $newMovementType, $newPrice) {
		try {
			$this->setMovementId($newMovementId);
			$this->setFromLocationId($newFromLocationId);
			$this->setToLocationId($newToLocationId);
			$this->setProductId($newProductId);
			$this->setUnitId($newUnitId);
			$this->setCost($newCost);
			$this->setMovementDate($newMovementDate);
			$this->setMovementType($newMovementType);
			$this->setPrice($newPrice);
		} catch(InvalidArgumentException $invalidArgument) {
			// rethrow the exception to the caller
			throw(new InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(RangeException $range) {
			// rethrow the exception to the caller
			throw(new RangeException($range->getMessage(), 0, $range));
		} catch(Exception $exception) {
			// rethrow the generic exception to the caller
			throw(new Exception($exception->getMessage(), 0, $exception));
		}
	}

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
	 * @param int $newMovementId new value of movementId
	 **/
	public function setMovementId($newMovementId) {
		// base case: if the movementId is null,
		// this is a new movement without a mySQL assigned id (yet)
		if($newMovementId === null) {
			$this->movementId = null;
			return;
		}

		// verify the movementId is valid
		$newMovementId = filter_var($newMovementId, FILTER_VALIDATE_INT);
		if($newMovementId === false) {
			throw(new InvalidArgumentException("movementId is not a valid integer"));
		}

		// verify the movementId is positive
		if($newMovementId <= 0) {
			throw(new RangeException("movementId is not positive"));
		}

		// convert and store the movementId
		$this->movementId = intval($newMovementId);
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
	 * @param int $newFromLocationId
	 */
	public function setFromLocationId($newFromLocationId) {
		// verify the fromLocationId is valid
		$newFromLocationId = filter_var($newFromLocationId, FILTER_VALIDATE_INT);
		if($newFromLocationId === false) {
			throw(new InvalidArgumentException("fromLocationId is not a valid integer"));
		}

		// verify the fromLocationId is positive
		if($newFromLocationId <= 0) {
			throw(new RangeException("fromLocationId is not positive"));
		}

		// convert and store the fromLocationId
		$this->fromLocationId = intval($newFromLocationId);
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
	 * @param int $newToLocationId
	 **/
	public function setToLocationId($newToLocationId) {
		// verify the toLocationId is valid
		$newToLocationId = filter_var($newToLocationId, FILTER_VALIDATE_INT);
		if($newToLocationId === false) {
			throw(new InvalidArgumentException("toLocationId is not a valid integer"));
		}

		// verify the toLocationId is positive
		if($newToLocationId <= 0) {
			throw(new RangeException("toLocationId is not positive"));
		}

		// convert and store the toLocationId
		$this->toLocationId = intval($newToLocationId);
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
	 * @param int $newProductId
	 **/
	public function setProductId($newProductId) {

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
	 * @param int $newUnitId
	 */
	public function setUnitId($newUnitId) {

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
	 * @param float $newCost
	 */
	public function setCost($newCost) {

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
	 * @param string $newMovementDate
	 */
	public function setMovementDate($newMovementDate) {

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
	 * @param string $newMovementType
	 */
	public function setMovementType($newMovementType) {

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
	 * @param float $newPrice
	 */
	public function setPrice($newPrice) {

	}
}