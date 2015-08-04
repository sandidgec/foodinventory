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
	 * Constructor for Unit of Measure
	 * @param $newUnitId
	 * @param $newUnitCode
	 * @param $newQuantity
	 */
	public function __construct($newUnitId, $newUnitCode, $newQuantity) {
		try {
			$this->setUnitId($unitId);
			$this->setUnitCode($unitCode);
			$this->setQuantity($quantity);
		} catch
		(InvalidArgumentException $invalidArgument) {
			//rethrow the exception to the caller
			throw(new InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		}
	}


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

	/**
	 * insert PDO
	 * @param PDO $pdo
	 */
	public function insert(PDO &$pdo) {
		// make sure unit id doesn't already exist
		if($this->unitId !== null) {
			throw (new PDOException("existing unitId"));
		}
		//create query template
		$query
			= "INSERT INTO unitOfMeasure(unitId, unitCode,quantity)
		VALUES (:unitId, :unitCode, :quantity)";
		$statement = $pdo->prepare($query);

		// bind the variables to the place holders in the template
		$parameters = array("unitId" => $this->unitId, "storageCode" => $this->unitCode, "quantity" => $this->quantity);

		$statement->execute($parameters);

		//update null userId with what mySQL just gave us
		$this->unitId = intval($pdo->lastInsertId());
	}

	/**
	 * Delete PDO
	 * @param PDO $pdo
	 */
	public function delete(PDO &$pdo) {
		// enforce the unitId is not null
		if($this->unitId === null) {
			throw(new PDOException("unable to delete a unitId that does not exist"));
		}

		//create query template
		$query = "DELETE FROM unitOfMeasure WHERE unitId = :unitId";
		$statement = $pdo->prepare($query);

		//bind the member variables to the place holder in the template
		$parameters = array("unitId" => $this->unitId);
		$statement->execute($parameters);
	}

	/**
	 * Update PDO
	 * @param PDO $pdo
	 */
	public function update(PDO &$pdo) {

		// create query template
		$query	 = "UPDATE unitOfMeasure SET unitId = :unitId, unitCode = :unitCode, quantity = :quantity WHERE unitId = :UnitId";
		$statement = $pdo->prepare($query);

		// bind the member variables
		$parameters = array("unitId" => $this->unitId, "unitCode" => $this->unitCode, "quantity" => $this->quantity);
		$statement->execute($parameters);
	}


	/**
	 * Get unitOfMeasure by unitId
	 * @param PDO $pdo
	 * @param $unitId
	 * @return mixed
	 */
	public static function getUnitOfMeasureByUnitId(PDO &$pdo, $unitId) {
		// sanitize the location id before searching
		$unitId = filter_var($unitId, FILTER_VALIDATE_INT);
		if($unitId=== false) {
			throw(new PDOException("unit id is not an integer"));
		}
		if($unitId <= 0) {
			throw(new PDOException("unit id is not positive"));
		}

		// create query template
		$query = "SELECT unitId, unitCode, quantity FROM unitOfMeasure WHERE unitId = :unitId";
		$statement = $pdo->prepare($query);

		// bind the unit id to the place holder in the template
		$parameters = array("unitId" => $unitId);
		$statement->execute($parameters);

		// grab the UnitOfMeasure from mySQL
		try {
			$UnitOfMeasure = null;
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$row   = $statement->fetch();
			if($row !== false) {
				$UnitOfMeasure = new UnitOfMeasure ($row["unitId"], $row["unitCode"], $row["quantity"]);
			}
		} catch(Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new PDOException($exception->getMessage(), 0, $exception));
		}
		return($unitId);
	}

	/**
	 * get unitOfMeasure by unitCode
	 * @param PDO $pdo
	 * @param $unitOfMeasure
	 * @return null|UnitOfMeasure
	 */
	public static function getUnitOfMeasureByUnitCode(PDO &$pdo, $unitOfMeasure) {
		// sanitize the storageCode before searching
		$unitOfMeasure = filter_var($unitOfMeasure, FILTER_VALIDATE_INT);
		if($unitOfMeasure === false) {
			throw(new PDOException(""));
		}
		if($unitOfMeasure <= 0) {
			throw(new PDOException("unit code is not positive"));
		}

		// create query template
		$query = "SELECT unitId, unitCode, quantity FROM unitOfMeasure WHERE unitCode = :unitCode";
		$statement = $pdo->prepare($query);

		// bind the unit code  to the place holder in the template
		$parameters = array("unitCode" => $unitOfMeasure);
		$statement->execute($parameters);

		// grab the unit of measure from mySQL
		try {
			$unitOfMeasure = null;
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$row   = $statement->fetch();
			if($row !== false) {
				$unitOfMeasure = new unitOfMeasure($row["unitId"], $row["unitCode"], $row["quantity"]);
			}
		} catch(Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new PDOException($exception->getMessage(), 0, $exception));
		}
		return($unitOfMeasure);
	}
}

