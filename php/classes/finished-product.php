<?php

/**
 * The finishedProduct class for Inventory
 *
 * This class will separate raw materials from finished products
 * multi-line
 *
 * @author Christopher Collopy <ccollopy@cnm.edu>
 **/
class finishedProduct {
	/**
	 * id for the finished product; this is a foreign key
	 * @var int $finishedProductId
	 **/
	private $finishedProductId;

	/**
	 * id for the raw material; this is a foreign key
	 * @var int $rawMaterialId
	 **/
	private $rawMaterialId;

	/**
	 * number of the raw material used in finished product
	 * @var float $rawQuantity
	 **/
	private $rawQuantity;

	/**
	 * @param int $newFinishedProductId id for the finished product
	 * @param int $newRawMaterialId id for the raw material
	 * @param float $newRawQuantity number of the raw material used in finished product
	 * @throws InvalidArgumentException if data types are not valid
	 * @throws RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws Exception if some other exception is thrown
	 */

	public function __construct($newFinishedProductId, $newRawMaterialId, $newRawQuantity) {
		try {
			$this->setFinishedProductId($newFinishedProductId);
			$this->setRawMaterialId($newRawMaterialId);
			$this->setRawQuantity($newRawQuantity);
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

	public function __toString() {
		return "<tr><td>" . $this->getFinishedProductId() . "</td><td>" . $this->getRawMaterialId() . "</td><td>" . $this->getRawQuantity() . "</td></tr>";
	}

	/**
	 * accessor method for finishedProductId
	 *
	 * @return int value of finishedProductId
	 */
	public function getFinishedProductId() {
		return $this->finishedProductId;
	}

	/**
	 * mutator method for finishedProductId
	 *
	 * @param int $newFinishedProductId
	 * @throws InvalidArgumentException if $newProductId is not a valid integer
	 * @throws RangeException if $newProductId is not positive
	 */
	public function setFinishedProductId($newFinishedProductId) {
		// verify the finishedProductId is valid
		$newFinishedProductId = filter_var($newFinishedProductId, FILTER_VALIDATE_INT);
		if($newFinishedProductId === false) {
			throw(new InvalidArgumentException("finishedProductId is not a valid integer"));
		}

		// verify the finishedProductId is positive
		if($newFinishedProductId <= 0) {
			throw(new RangeException("finishedProductId is not positive"));
		}

		// convert and store the finishedProductId
		$this->finishedProductId = intval($newFinishedProductId);
	}

	/**
	 * accessor method for rawMaterialId
	 *
	 * @return int value of rawMaterialId
	 */
	public function getRawMaterialId() {
		return $this->rawMaterialId;
	}

	/**
	 * mutator method for rawMaterialId
	 *
	 * @param int $newRawMaterialId
	 * @throws InvalidArgumentException if $newRawMaterial is not a valid integer
	 * @throws RangeException if $newRawMaterial is not positive
	 */
	public function setRawMaterialId($newRawMaterialId) {
		// verify the rawMaterialId is valid
		$newRawMaterialId = filter_var($newRawMaterialId, FILTER_VALIDATE_INT);
		if($newRawMaterialId === false) {
			throw(new InvalidArgumentException("rawMaterialId is not a valid integer"));
		}

		// verify the rawMaterialId is positive
		if($newRawMaterialId <= 0) {
			throw(new RangeException("rawMaterialId is not positive"));
		}

		// convert and store the rawMaterialId
		$this->rawMaterialId = intval($newRawMaterialId);
	}

	/**
	 * accessor method for rawQuantity
	 *
	 * @return float value of rawQuantity
	 */
	public function getRawQuantity() {
		return $this->rawQuantity;
	}

	/**
	 * mutator method for rawQuantity
	 *
	 * @param float $newRawQuantity
	 * @throws InvalidArgumentException if $newRawQuantity is not a valid float
	 * @throws RangeException if $newRawQuantity is not positive
	 */
	public function setRawQuantity($newRawQuantity) {
		// verify the rawQuantity is valid
		$newRawQuantity = filter_var($newRawQuantity, FILTER_VALIDATE_FLOAT);
		if($newRawQuantity === false) {
			throw(new InvalidArgumentException("rawQuantity is not a valid float"));
		}

		// verify the rawQuantity is positive
		if($newRawQuantity <= 0) {
			throw(new RangeException("rawQuantity is not positive"));
		}

		// convert and store the rawQuantity
		$this->rawQuantity = floatval($newRawQuantity);
	}

	/**
	 * inserts this FinishedProduct into mySQL
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @throws PDOException when mySQL related errors occur
	 **/
	public function insert(PDO &$pdo) {
		// enforce the finishedProductId is not null (i.e., don't update a location that hasn't been inserted)
		if($this->finishedProductId === null) {
			throw(new PDOException("unable to update a finishedProductId that does not exist"));
		}

		// enforce the rawMaterialId is not null (i.e., don't update a product that hasn't been inserted)
		if($this->rawMaterialId === null) {
			throw(new PDOException("unable to update a rawMaterialId that does not exist"));
		}

		// create query template
		$query = "INSERT INTO finishedProduct(finishedProductId, rawMaterialId, rawQuantity)
 					 VALUES(:finishedProductId, :rawMaterialId, :rawQuantity)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = array("finishedProductId" => $this->finishedProductId, "rawMaterialId" => $this->rawMaterialId, "rawQuantity" => $this->rawQuantity);
		$statement->execute($parameters);
	}

	/**
	 * updates this FinishedProduct in mySQL
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @throws PDOException when mySQL related errors occur
	 **/
	public function update(PDO &$pdo) {
		// enforce the finishedProductId is not null (i.e., don't update a location that hasn't been inserted)
		if($this->finishedProductId === null) {
			throw(new PDOException("unable to update a finishedProductId that does not exist"));
		}

		// enforce the rawMaterialId is not null (i.e., don't update a product that hasn't been inserted)
		if($this->rawMaterialId === null) {
			throw(new PDOException("unable to update a rawMaterialId that does not exist"));
		}

		// create query template
		$query = "UPDATE finishedProduct SET rawQuantity = :rawQuantity WHERE finishedProductId = :finishedProductId AND rawMaterialId = :rawMaterialId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = array("finishedProductId" => $this->finishedProductId, "rawMaterialId" => $this->rawMaterialId, "rawQuantity" => $this->rawQuantity);
		$statement->execute($parameters);
	}

	/**
	 * deletes this FinishedProduct from mySQL
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @throws PDOException when mySQL related errors occur
	 **/
	public function delete(PDO &$pdo) {
		// enforce the finishedProductId is not null (i.e., don't update a location that hasn't been inserted)
		if($this->finishedProductId === null) {
			throw(new PDOException("unable to update a finishedProductId that does not exist"));
		}

		// enforce the rawMaterialId is not null (i.e., don't update a product that hasn't been inserted)
		if($this->rawMaterialId === null) {
			throw(new PDOException("unable to update a rawMaterialId that does not exist"));
		}

		// create query template
		$query = "DELETE FROM finishedProduct WHERE finishedProductId = :finishedProductId AND rawMaterialId = :rawMaterialId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holder in the template
		$parameters = array("finishedProductId" => $this->finishedProductId, "rawMaterialId" => $this->rawMaterialId);
		$statement->execute($parameters);
	}

	/**
	 * gets the FinishedProduct by finishedProductId & rawMaterialId
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @param int $newFinishedProductId the finishedProductId to search for
	 * @param int $newRawMaterialId the rawMaterialId to search for
	 * @return mixed FinishedProduct(s) found or null if not found
	 * @throws PDOException when mySQL related errors occur
	 **/
	public static function getProductLocationByLocationIdAndProductId(PDO &$pdo, $newFinishedProductId, $newRawMaterialId) {
		// sanitize the finishedProductId before searching
		$newFinishedProductId = filter_var($newFinishedProductId, FILTER_VALIDATE_INT);
		if($newFinishedProductId === false) {
			throw(new PDOException("finishedProductId is not an integer"));
		}
		if($newFinishedProductId <= 0) {
			throw(new PDOException("finishedProductId is not positive"));
		}

		// sanitize the rawMaterialId before searching
		$newRawMaterialId = filter_var($newRawMaterialId, FILTER_VALIDATE_INT);
		if($newRawMaterialId === false) {
			throw(new PDOException("rawMaterialId is not an integer"));
		}
		if($newRawMaterialId <= 0) {
			throw(new PDOException("rawMaterialId is not positive"));
		}

		// create query template
		$query	 = "SELECT finishedProductId, rawMaterialId, rawQuantity FROM finishedProduct WHERE finishedProductId = :finishedProductId AND rawMaterialId = :rawMaterialId";
		$statement = $pdo->prepare($query);

		// bind the finishedProductId and the rawMaterialId to the place holder in the template
		$parameters = array("finishedProductId" => $newFinishedProductId, "rawMaterialId" => $newRawMaterialId);
		$statement->execute($parameters);

		// build an array of FinishedProducts
		$finishedProducts = new SplFixedArray($statement->rowCount());
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$finishedProduct = new FinishedProduct($row["finishedProductId"], $row["rawMaterialId"], $row["rawQuantity"]);
				$finishedProducts[$finishedProducts->key()] = $finishedProduct;
				$finishedProducts->next();
			} catch(Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($finishedProducts);
	}

	/**
	 * gets the FinishedProduct by finishedProductId
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @param int $newFinishedProductId the finishedProductId to search for
	 * @return mixed FinishedProduct(s) found or null if not found
	 * @throws PDOException when mySQL related errors occur
	 **/
	public static function getProductLocationByLocationId(PDO &$pdo, $newFinishedProductId) {
		// sanitize the finishedProductId before searching
		$newFinishedProductId = filter_var($newFinishedProductId, FILTER_VALIDATE_INT);
		if($newFinishedProductId === false) {
			throw(new PDOException("finishedProductId is not an integer"));
		}
		if($newFinishedProductId <= 0) {
			throw(new PDOException("finishedProductId is not positive"));
		}

		// create query template
		$query	 = "SELECT finishedProductId, rawMaterialId, rawQuantity FROM finishedProduct WHERE finishedProductId = :finishedProductId";
		$statement = $pdo->prepare($query);

		// bind the finishedProductId to the place holder in the template
		$parameters = array("finishedProductId" => $newFinishedProductId);
		$statement->execute($parameters);

		// build an array of productLocations
		$finishedProducts = new SplFixedArray($statement->rowCount());
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$finishedProduct = new FinishedProduct($row["finishedProductId"], $row["rawMaterialId"], $row["rawQuantity"]);
				$finishedProducts[$finishedProducts->key()] = $finishedProduct;
				$finishedProducts->next();
			} catch(Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($finishedProducts);
	}

	/**
	 * gets the FinishedProduct by rawMaterialId
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @param int $newRawMaterialId the rawMaterialId to search for
	 * @return mixed FinishedProduct(s) found or null if not found
	 * @throws PDOException when mySQL related errors occur
	 **/
	public static function getProductLocationByProductId(PDO &$pdo, $newRawMaterialId) {
		// sanitize the rawMaterialId before searching
		$newRawMaterialId = filter_var($newRawMaterialId, FILTER_VALIDATE_INT);
		if($newRawMaterialId === false) {
			throw(new PDOException("rawMaterialId is not an integer"));
		}
		if($newRawMaterialId <= 0) {
			throw(new PDOException("rawMaterialId is not positive"));
		}

		// create query template
		$query	 = "SELECT finishedProductId, rawMaterialId, rawQuantity FROM finishedProduct WHERE rawMaterialId = :rawMaterialId";
		$statement = $pdo->prepare($query);

		// bind the rawMaterialId to the place holder in the template
		$parameters = array("rawMaterialId" => $newRawMaterialId);
		$statement->execute($parameters);

		// build an array of FinishedProduct(s)
		$finishedProducts = new SplFixedArray($statement->rowCount());
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$finishedProduct = new FinishedProduct($row["finishedProductId"], $row["rawMaterialId"], $row["rawQuantity"]);
				$finishedProducts[$finishedProducts->key()] = $finishedProduct;
				$finishedProducts->next();
			} catch(Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($finishedProducts);
	}

	/**
	 * gets all finishedProducts
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @return SplFixedArray all productLocations found
	 * @throws PDOException when mySQL related errors occur
	 **/
	public static function getAllFinishedProducts(PDO &$pdo) {
		// create query template
		$query = "SELECT finishedProductId, rawMaterialId, rawQuantity FROM finishedProduct";
		$statement = $pdo->prepare($query);
		$statement->execute();

		// build an array of productLocations
		$finishedProducts = new SplFixedArray($statement->rowCount());
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$finishedProduct = new FinishedProduct($row["finishedProductId"], $row["rawMaterialId"], $row["rawQuantity"]);
				$finishedProducts[$finishedProducts->key()] = $finishedProduct;
				$finishedProducts->next();
			} catch(Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($finishedProducts);
	}
}