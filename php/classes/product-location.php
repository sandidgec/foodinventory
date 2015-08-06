<?php

/**
 * The productLocation class for Inventory
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
	 * id for the product at the location; this is a foreign key
	 * @var int $productId
	 **/
	private $productId;

	/**
	 * id for the units of the product at the location; this is a foreign key
	 * @var int $unitId
	 **/
	private $unitId;

	/**
	 * number of that products at the location
	 * @var float $quantity
	 **/
	private $quantity;

	/**
	 * @param int $newLocationId id for the location
	 * @param int $newProductId id for the product at the location
	 * @param int $newUnitId id for the units of the product at the location
	 * @param float $newQuantity number of the products at the location
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

	public function __toString() {
		return "<tr><td>" . $this->getLocationId() . "</td><td>" . $this->getProductId() . "</td><td>" . $this->getUnitId() . "</td><td>" . $this->getQuantity() . "</td></tr>";
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
	 * @throws InvalidArgumentException if $newLocationId is not a valid integer
	 * @throws RangeException if $newLocationId is not positive
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
	 * @throws InvalidArgumentException if $newProductId is not a valid integer
	 * @throws RangeException if $newProductId is not positive
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
	 * @throws InvalidArgumentException if $newUnitId is not a valid integer
	 * @throws RangeException if $newUnitId is not positive
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
	 * @return float value of quantity
	 */
	public function getQuantity() {
		return $this->quantity;
	}

	/**
	 * mutator method for quantity
	 *
	 * @param float $newQuantity
	 * @throws InvalidArgumentException if $newQuantity is not a valid float
	 * @throws RangeException if $newQuantity is not positive
	 */
	public function setQuantity($newQuantity) {
		// verify the quantity is valid
		$newQuantity = filter_var($newQuantity, FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_THOUSAND);
		if($newQuantity === false) {
			throw(new InvalidArgumentException("quantity is not a valid float"));
		}

		// verify the quantity is positive
		if($newQuantity <= 0) {
			throw(new RangeException("quantity is not positive"));
		}

		// convert and store the quantity
		$this->quantity = floatval($newQuantity);
	}

	/**
	 * inserts this ProductLocation into mySQL
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @throws PDOException when mySQL related errors occur
	 **/
	public function insert(PDO &$pdo) {
		// enforce the locationId is not null (i.e., don't update a location that hasn't been inserted)
		if($this->locationId === null) {
			throw(new PDOException("unable to update a location that does not exist"));
		}

		// enforce the productId is not null (i.e., don't update a product that hasn't been inserted)
		if($this->productId === null) {
			throw(new PDOException("unable to update a profile that does not exist"));
		}

		// enforce the unitId is not null (i.e., don't update a unit that hasn't been inserted)
		if($this->unitId === null) {
			throw(new PDOException("unable to update a unit that does not exist"));
		}
		// create query template
		$query = "INSERT INTO productLocation(locationId, productId, unitId, quantity)
 					 VALUES(:locationId, :productId, :unitId, :quantity)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = array("locationId" => $this->locationId, "productId" => $this->productId, "unitId" => $this->unitId, "quantity" => $this->quantity);
		$statement->execute($parameters);
	}

	/**
	 * updates this ProductLocation in mySQL
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @throws PDOException when mySQL related errors occur
	 **/
	public function update(PDO &$pdo) {
		// enforce the locationId is not null (i.e., don't update a location that hasn't been inserted)
		if($this->locationId === null) {
			throw(new PDOException("unable to update a location that does not exist"));
		}

		// enforce the productId is not null (i.e., don't update a product that hasn't been inserted)
		if($this->productId === null) {
			throw(new PDOException("unable to update a profile that does not exist"));
		}

		// enforce the unitId is not null (i.e., don't update a unit that hasn't been inserted)
		if($this->unitId === null) {
			throw(new PDOException("unable to update a unit that does not exist"));
		}

		// create query template
		$query = "UPDATE productLocation SET quantity = :quantity WHERE locationId = :locationId AND productId = :productId AND unitId = :unitId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = array("locationId" => $this->locationId, "productId" => $this->productId, "unitId" => $this->unitId, "quantity" => $this->quantity);
		$statement->execute($parameters);
	}

	/**
	 * deletes this ProductLocation from mySQL
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @throws PDOException when mySQL related errors occur
	 **/
	public function delete(PDO &$pdo) {
		// enforce the locationId is not null (i.e., don't delete a location that hasn't been inserted)
		if($this->locationId === null) {
			throw(new PDOException("unable to delete a location that does not exist"));
		}

		// enforce the productId is not null (i.e., don't delete a product that hasn't been inserted)
		if($this->productId === null) {
			throw(new PDOException("unable to delete a profile that does not exist"));
		}

		// enforce the unitId is not null (i.e., don't delete a unit that hasn't been inserted)
		if($this->unitId === null) {
			throw(new PDOException("unable to delete a unit that does not exist"));
		}

		// create query template
		$query = "DELETE FROM productLocation WHERE locationId = :locationId AND productId = :productId AND unitId = :unitId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holder in the template
		$parameters = array("locationId" => $this->locationId, "productId" => $this->productId, "unitId" => $this->unitId);
		$statement->execute($parameters);
	}

	/**
	 * gets the ProductLocation by locationId & productId
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @param int $newLocationId the locationId to search for
	 * @param int $newProductId the ProductId to search for
	 * @return mixed ProductLocation(s) found or null if not found
	 * @throws PDOException when mySQL related errors occur
	 **/
	public static function getProductLocationByLocationIdAndProductId(PDO &$pdo, $newLocationId, $newProductId) {
		// sanitize the locationId before searching
		$newLocationId = filter_var($newLocationId, FILTER_VALIDATE_INT);
		if($newLocationId === false) {
			throw(new PDOException("locationId is not an integer"));
		}
		if($newLocationId <= 0) {
			throw(new PDOException("locationId is not positive"));
		}

		// sanitize the productId before searching
		$newProductId = filter_var($newProductId, FILTER_VALIDATE_INT);
		if($newProductId === false) {
			throw(new PDOException("productId is not an integer"));
		}
		if($newProductId <= 0) {
			throw(new PDOException("productId is not positive"));
		}

		// create query template
		$query	 = "SELECT locationId, productId, unitId, quantity FROM productLocation WHERE locationId = :locationId AND productId = :productId";
		$statement = $pdo->prepare($query);

		// bind the locationId and the productId to the place holder in the template
		$parameters = array("locationId" => $newLocationId, "productId" => $newProductId);
		$statement->execute($parameters);

		// build an array of productLocations
		$productLocations = new SplFixedArray($statement->rowCount());
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$productLocation = new ProductLocation($row["locationId"], $row["productId"], $row["unitId"], $row["quantity"]);
				$productLocations[$productLocations->key()] = $productLocation;
				$productLocations->next();
			} catch(Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($productLocations);
	}

	/**
	 * gets the ProductLocation by locationId
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @param int $newLocationId the locationId to search for
	 * @return mixed ProductLocation(s) found or null if not found
	 * @throws PDOException when mySQL related errors occur
	 **/
	public static function getProductLocationByLocationId(PDO &$pdo, $newLocationId) {
		// sanitize the locationId before searching
		$newLocationId = filter_var($newLocationId, FILTER_VALIDATE_INT);
		if($newLocationId === false) {
			throw(new PDOException("locationId is not an integer"));
		}
		if($newLocationId <= 0) {
			throw(new PDOException("locationId is not positive"));
		}

		// create query template
		$query	 = "SELECT locationId, productId, unitId, quantity FROM productLocation WHERE locationId = :locationId";
		$statement = $pdo->prepare($query);

		// bind the userId to the place holder in the template
		$parameters = array("locationId" => $newLocationId);
		$statement->execute($parameters);

		// build an array of productLocations
		$productLocations = new SplFixedArray($statement->rowCount());
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$productLocation = new ProductLocation($row["locationId"], $row["productId"], $row["unitId"], $row["quantity"]);
				$productLocations[$productLocations->key()] = $productLocation;
				$productLocations->next();
			} catch(Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($productLocations);
	}

	/**
	 * gets the ProductLocation by productId
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @param int $newProductId the productId to search for
	 * @return mixed ProductLocation(s) found or null if not found
	 * @throws PDOException when mySQL related errors occur
	 **/
	public static function getProductLocationByProductId(PDO &$pdo, $newProductId) {
		// sanitize the productId before searching
		$newProductId = filter_var($newProductId, FILTER_VALIDATE_INT);
		if($newProductId === false) {
			throw(new PDOException("productId is not an integer"));
		}
		if($newProductId <= 0) {
			throw(new PDOException("productId is not positive"));
		}

		// create query template
		$query	 = "SELECT locationId, productId, unitId, quantity FROM productLocation WHERE productId = :productId";
		$statement = $pdo->prepare($query);

		// bind the productId to the place holder in the template
		$parameters = array("productId" => $newProductId);
		$statement->execute($parameters);

		// build an array of productLocations
		$productLocations = new SplFixedArray($statement->rowCount());
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$productLocation = new ProductLocation($row["locationId"], $row["productId"], $row["unitId"], $row["quantity"]);
				$productLocations[$productLocations->key()] = $productLocation;
				$productLocations->next();
			} catch(Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($productLocations);
	}

	/**
	 * gets all ProductLocations
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @return SplFixedArray all productLocations found
	 * @throws PDOException when mySQL related errors occur
	 **/
	public static function getAllProductLocations(PDO &$pdo) {
		// create query template
		$query = "SELECT locationId, productId, unitId, quantity FROM productLocation";
		$statement = $pdo->prepare($query);
		$statement->execute();

		// build an array of productLocations
		$productLocations = new SplFixedArray($statement->rowCount());
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$productLocation = new ProductLocation($row["locationId"], $row["productId"], $row["unitId"], $row["quantity"]);
				$productLocations[$productLocations->key()] = $productLocation;
				$productLocations->next();
			} catch(Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($productLocations);
	}
}
