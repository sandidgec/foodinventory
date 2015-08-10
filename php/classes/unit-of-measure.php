<?php

class UnitOfMeasure {

	/**
	 * primary key for unitOfMeasure
	 * @var int for $unitId
	 **/
private $unitId;

	/**
	 * the identity of quantity of a unit - i.e. ea (for each)
	 * @var string for $unitCode
	 **/
private $unitCode;

	/**
	 * the quantity of a unit
	 * @var float for $quantity
	 **/
private $quantity;


	/**
	 * Constructor for unit of measure class
	 *
	 *
	 * @param int $newUnitId
	 * @param string $newUnitCode
	 * @param float $newQuantity
	 * @throws Exception
	 * @throws RangeException
	 * @throws InvalidArgumentException
	 **/
	public function __construct($newUnitId, $newUnitCode, $newQuantity) {
		try {
			$this->setUnitId($newUnitId);
			$this->setUnitCode($newUnitCode);
			$this->setQuantity($newQuantity);
		} catch
		(InvalidArgumentException $invalidArgument) {
			//rethrow the exception to the caller
				throw(new InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch
		(RangeException $range)  {
		// rethrow the exception to the caller
				throw (new RangeException($range->getMessage(),0, $range));
		} catch(Exception $exception) {
			// rethrow generic exception
				throw(new Exception($exception->getMessage(), 0, $exception));
		}
	}


	/**
	 * accessor for unit id
	 * @return int
	 **/
	public function getUnitId() {
		return ($this->unitId);
	}

	/**
	 * mutator for Unit Id
	 * @param int $newUnitId
	 * @throws InvalidArgumentException for invalid content
	 **/
	public function setUnitId($newUnitId) {
		// base case: if the unitId is null,
		// this is a new unit Id without a mySQL assigned id (yet)
		if($newUnitId === null) {
			$this->unitId = null;
			return;
		}
		//verify the locationId is valid
		$newUnitId = filter_var($newUnitId, FILTER_VALIDATE_INT);
		if(empty($newUnitId) === true) {
			throw (new InvalidArgumentException ("unit id invalid"));
		}
		$this->unitId = $newUnitId;
	}

	/**
	 * accessor for unit code
	 * @return string
	 **/
	public function getUnitCode() {
		return ($this->unitCode);
	}

	/**
	 * mutator for unit code
	 * @param string $newUnitCode
	 * @throws InvalidArgumentException for invalid content
	 * @throws RangeException for more than 2 characters
	 **/
	public function setUnitCode($newUnitCode) {
		//verify the locationId is valid
		$newUnitCode = filter_var($newUnitCode, FILTER_SANITIZE_STRING);
		if(empty($newUnitCode) === true) {
			throw (new InvalidArgumentException ("unit code invalid"));
		}
			if(strlen($newUnitCode) !== 2) {
				throw new RangeException ("Invalid UnitCode Entry");
			}
		$this->unitCode = $newUnitCode;
	}

	/**
	 * accessor for Quantity
	 * @return float
	 **/
	public function getQuantity() {
		return ($this->quantity);
	}

	/**
	 * mutator for Quantity
	 * @param float value for $newQuantity
	 * @throws InvalidArgumentException for invalid content
	 * @throws RangeException for negative quantity value
	 **/
	public function setQuantity($newQuantity) {
		//verify the quantity is valid
		$newQuantity = filter_var($newQuantity, FILTER_VALIDATE_FLOAT);
		if(empty($newQuantity) === true) {
			throw (new InvalidArgumentException ("quantity invalid"));
		}
		// verify the quantity is positive
		if($newQuantity < 0) {
			throw(new RangeException("quantity is a negative value"));
		}
		$this->quantity = floatval($newQuantity);
	}

	/**
	 * insert PDO
	 * @param PDO $pdo pointer to PDO connection, by reference
	 **/
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
		$parameters = array("unitId" => $this->unitId, "unitCode" => $this->unitCode, "quantity" => $this->quantity);

		$statement->execute($parameters);

		//update null unitId with what mySQL just gave us
		$this->unitId = intval($pdo->lastInsertId());
	}

	/**
	 * Delete PDO
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @throws PDOException for mySQL related errors
	 **/
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
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @throws PDOException for mySQL related issues
	 **/
	public function update(PDO &$pdo) {
	// enforce the unitId is not null
		if($this->unitId === null) {
			throw(new PDOException("unable to delete a unitId that does not exist"));
		}

		// create query template
		$query	 = "UPDATE unitOfMeasure SET unitCode = :unitCode, quantity = :quantity WHERE unitId = :unitId";
		$statement = $pdo->prepare($query);

		// bind the member variables
		$parameters = array("unitCode" => $this->unitCode, "quantity" => $this->quantity, "unitId" => $this->unitId);
		$statement->execute($parameters);
	}


	/**
	 * Get unitOfMeasure by unitId
	 * @param PDO $pdo
	 * @param int $unitId
	 * @return mixed UnitOfMeasure
	 * @throws PDOException if unit id is not an integer
	 * @throws PDOException if unit id is not positive in mySQL
	 * @throws PDOException if row couldn't be converted in mySQL
	 **/
	public static function getUnitOfMeasureByUnitId(PDO &$pdo, $unitId) {
		// sanitize the unitId before searching
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
		} catch(PDOException $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new PDOException($exception->getMessage(), 0, $exception));
		}
		return($UnitOfMeasure);
	}

	/**
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @param string $newUnitCode
	 * @return null|UnitOfMeasure
	 * @throws InvalidArgumentException if UnitCode not a valid string
	 * @throws RangeException if UnitCode is not exactly 2 characters
	 **/
	public static function getUnitOfMeasureByUnitCode(PDO &$pdo, $newUnitCode) {
		// sanitize the storageCode before searching
		$newUnitCode = filter_var($newUnitCode, FILTER_SANITIZE_STRING);
		if($newUnitCode === false) {
			throw(new InvalidArgumentException("invalid unitCode "));
		}
		if(strlen($newUnitCode) !== 2) {
			throw(new RangeException("unit code is not valid length"));
		}

		// create query template
		$query = "SELECT unitId, unitCode, quantity FROM unitOfMeasure WHERE unitCode = :unitCode";
		$statement = $pdo->prepare($query);

		// bind the unit code  to the place holder in the template
		$parameters = array("unitCode" => $newUnitCode);
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

