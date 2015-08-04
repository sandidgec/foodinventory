<?php

class UnitOfMeasure {

	/**
	 * @var int $unitId
	 */
private $unitId;

	/**
	 * @var int $unitCode
	 */
private $unitCode;

	/**
	 * @var string $quantity
	 */
private $quantity;

	/**
	 * accessor for unit id
	 * @return int
	 */
	public function getUnitId() {
		return ($this->unitId);
	}

	/**
	 * mutator for Unit Id
	 * @param $newUnitId
	 */
	public function setUnitId($newUnitId) {
		//verify the locationId is valid
		$newUnitId = filter_var($newUnitId, FILTER_VALIDATE_INT);
		if(empty($newUnitId) === true) {
			throw (new InvalidArgumentException ("content invalid"));
		}
		$this->unitId = $newUnitId;
	}

	/**
	 * accessor for unit code
	 * @return int
	 */
	public function getUnitCode() {
		return ($this->unitCode);
	}

	/**
	 * mutator for unit code
	 * @param $newUnitCode
	 */
	public function setUnitCode($newUnitCode) {
		//verify the locationId is valid
		$newUnitCode = filter_var($newUnitCode, FILTER_VALIDATE_INT);
		if(empty($newUnitCode) === true) {
			throw (new InvalidArgumentException ("content invalid"));
		}
		$this->unitCode = $newUnitCode;
	}

	/**
	 * accessor for Quantity
	 * @return string
	 */
	public function getQuantity() {
		return ($this->quantity);
	}

	/**
	 * mutator for Quantity
	 * @param $newQuantity
	 */
	public function setQuantity($newQuantity) {
		//verify the locationId is valid
		$newQuantity = filter_var($newQuantity, FILTER_VALIDATE_INT);
		if(empty($newQuantity) === true) {
			throw (new InvalidArgumentException ("content invalid"));
		}
		$this->quantity = $newQuantity;
	}
}

