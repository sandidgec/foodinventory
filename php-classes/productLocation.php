<?php

/**
 * The productLocation class for inventoryText
 *
 * This class will attach a location to each individual product
 * multi-line
 *
 * @author Christopher Collopy <ccollopy@cnm.edu>
 **/
class productLocation {
	/**
	 * id for the location; this is a foreign key
	 * @var int $locationId
	 **/
	private $locationId;

	/**
	 * id for the product; this is a foreign key
	 * @var int $productId
	 **/
	private $productId;

	/**
	 * id for the units of the product; this is a foreign key
	 * @var int $unitId
	 **/
	private $unitId;

	/**
	 * number of products at the location
	 * @var int $quantity
	 **/
	private $quantity;

	/**
	 * @param int $newLocationId id for the location
	 * @param int $newProductId id for the product at the location
	 * @param int $newUnitId id for the units of the product at the location
	 * @param int $newQuantity quantity of the product at the location
	 * @throws InvalidArgumentException if data types are not valid
	 * @throws RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws Exception if some other exception is thrown
	 */

	public function __construct($newLocationId, $newProductId, $newUnitId, $newQuantity) {
		try {
			$this->setLocationId($newLocationId);
			$this->setProductId($newProductId);
			$this->setUnitId($newUnitId);
			$this->setQuantity($newQuantity);
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
	 * accessor method for locationId
	 *
	 * @return int value of locationId
	 */
	public function getLocationId() {
		return $this->locationId;
	}

	/**
	 * mutator method for locationId
	 *
	 * @param int $newLocationId
	 */
	public function setLocationId($newLocationId) {
		// verify the locationId is valid
		$newLocationId = filter_var($newLocationId, FILTER_VALIDATE_INT);
		if($newLocationId === false) {
			throw(new InvalidArgumentException("locationId is not a valid integer"));
		}

		// verify the locationId is positive
		if($newLocationId <= 0) {
			throw(new RangeException("locationId is not positive"));
		}

		// convert and store the locationId
		$this->locationId = intval($newLocationId);
	}

	/**
	 * accessor method for productId
	 *
	 * @return int value of productId
	 */
	public function getProductId() {
		return $this->productId;
	}

	/**
	 * mutator method for productId
	 *
	 * @param int $newProductId
	 */
	public function setProductId($newProductId) {
		// verify the productId is valid
		$newProductId = filter_var($newProductId, FILTER_VALIDATE_INT);
		if($newProductId === false) {
			throw(new InvalidArgumentException("productId is not a valid integer"));
		}

		// verify the productId is positive
		if($newProductId <= 0) {
			throw(new RangeException("productId is not positive"));
		}

		// convert and store the productId
		$this->productId = intval($newProductId);
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
		// verify the unitId is valid
		$newUnitId = filter_var($newUnitId, FILTER_VALIDATE_INT);
		if($newUnitId === false) {
			throw(new InvalidArgumentException("unitId is not a valid integer"));
		}

		// verify the unitId is positive
		if($newUnitId <= 0) {
			throw(new RangeException("unitId is not positive"));
		}

		// convert and store the unitId
		$this->unitId = intval($newUnitId);
	}

	/**
	 * accessor method for quantity
	 *
	 * @return int value of quantity
	 */
	public function getQuantity() {
		return $this->quantity;
	}

	/**
	 * mutator method for quantity
	 *
	 * @param int $newQuantity
	 */
	public function setQuantity($newQuantity) {
		// verify the quantity is valid
		$newQuantity = filter_var($newQuantity, FILTER_VALIDATE_INT);
		if($newQuantity === false) {
			throw(new InvalidArgumentException("quantity is not a valid integer"));
		}

		// verify the quantity is positive
		if($newQuantity <= 0) {
			throw(new RangeException("quantity is not positive"));
		}

		// convert and store the quantity
		$this->quantity = intval($newQuantity);
	}
}
