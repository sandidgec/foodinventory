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
	 * the date and time of the movement
	 * @var DateTime $movementDate
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

	use validateDate;

	/**
	 * @param int $newMovementId id for this Movement
	 * @param int $newFromLocationId id for the product's current location
	 * @param int $newToLocationId id for the product's new location
	 * @param int $newProductId id for the product being moved
	 * @param int $newUnitId id for the units being moved
	 * @param double $newCost cost of the product being moved
	 * @param DateTime $newMovementDate the date of the movement
	 * @param string $newMovementType the type of the movement
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


	public function __toString() {
		return "<tr><td><strong>Movement ID: </strong>" . $this->getMovementId() . "</td><td><strong>From Location ID: </strong>" . $this->getFromLocationId() .
				 "</td><td><strong>To Location ID: </strong>" . $this->getFromLocationId() . "</td><td><strong>Product ID: </strong>" . $this->getProductId() .
				 "</td><td><strong>Unit ID: </strong>" . $this->getUnitId() . "</td><td><strong>Cost: </strong>" . $this->getCost() .
				 "</td><td><strong>Movement Date: </strong>" . $this->getMovementDate() . "</td><td><strong>Movement Type: </strong>" . $this->getMovementType() .
				 "</td><td><strong>Price: </strong>" . $this->getPrice() . "</td></tr>";
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
	 * @throws InvalidArgumentException if $newMovementId is not an integer
	 * @throws RangeException if $newMovementId is not positive
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
	 * @throws InvalidArgumentException if $newFromLocationId is not an integer
	 * @throws RangeException if $newFromLocationId is not positive
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
	 * @throws InvalidArgumentException if $newToLocationId is not an integer
	 * @throws RangeException if $newToLocationId is not positive
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
	 * @throws InvalidArgumentException if $newProductId is not an integer
	 * @throws RangeException if $newFromProductId is not positive
	 **/
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
	 * @throws InvalidArgumentException if $newUnitId is not an integer
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
		// verify the cost is valid
		$newCost = filter_var($newCost, FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_THOUSAND);
		if($newCost === false) {
			throw(new InvalidArgumentException("cost is not a valid float"));
		}

		// verify the cost is positive
		if($newCost <= 0) {
			throw(new RangeException("cost is not positive"));
		}

		// convert and store the cost
		$this->cost = floatval($newCost);
	}

	/**
	 * accessor method for movementDate
	 *
	 * @return string value of movementDate
	 */
	public function getMovementDate() {
		return $this->movementDate;
	}

	/**
	 * mutator method for movementDate
	 *
	 * @param DateTime $newMovementDate
	 */
	public function setMovementDate($newMovementDate) {
		// base case: if the date is null, use the current date and time
		if($newMovementDate === null) {
			$this->movementDate = new DateTime();
			return;
		}

		// store the movementDate
		try {
			$newMovementDate = validateDate::validateDate($newMovementDate);
		} catch(InvalidArgumentException $invalidArgument) {
			throw(new InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(RangeException $range) {
			throw(new RangeException($range->getMessage(), 0, $range));
		}
		$this->movementDate = $newMovementDate;
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
	 * @throws InvalidArgumentException if $newMovementType is not a string
	 * @throws RangeException if $newMovementType is not 1 character long
	 */
	public function setMovementType($newMovementType) {
		// verify the movementType is secure
		$newMovementType = trim($newMovementType);
		$newMovementType = filter_var($newMovementType, FILTER_SANITIZE_STRING);
		if(empty($newMovementType) === true) {
			throw(new InvalidArgumentException("movementType is empty or insecure"));
		}

		// verify the movementType will fit in the database
		if(strlen($newMovementType) > 1) {
			throw(new RangeException("movementType is too large"));
		}

		// store the movementType
		$this->movementType = $newMovementType;
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
		// verify the price is valid
		$newPrice = filter_var($newPrice, FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_THOUSAND);
		if($newPrice === false) {
			throw(new InvalidArgumentException("price is not a valid float"));
		}

		// verify the price is positive
		if($newPrice <= 0) {
			throw(new RangeException("price is not positive"));
		}

		// convert and store the price
		$this->price = floatval($newPrice);
	}

	/**
	 * inserts this Movement into mySQL
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @throws PDOException when mySQL related errors occur
	 **/
	public function insert(PDO &$pdo) {
		// enforce the movementId is null (i.e., don't insert a movement that already exists)
		if($this->movementId !== null) {
			throw(new PDOException("not a new movement"));
		}

		// create query template
		$query = "INSERT INTO movement(movementId, fromLocationId, toLocationId, productId, unitId, cost, movementDate, movementType, price)
 					 VALUES(:movementId, :fromLocationId, :toLocationId, :productId, :unitId, :cost, :movementDate, :movementType, :price)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = array("fromLocationId" => $this->fromLocationId, "toLocationId" => $this->toLocationId, "productId" => $this->productId, "unitId" => $this->unitId,
								  "cost" => $this->cost, "movementDate" => $this->movementDate, "movementType" => $this->movementType, "price" => $this->price);
		$statement->execute($parameters);

		// update the null movementId with what mySQL just gave us
		$this->movementId = intval($pdo->lastInsertId());
	}


	/**
	 * deletes this Movement from mySQL
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @throws PDOException when mySQL related errors occur
	 **/
	public function delete(PDO &$pdo) {
		// enforce the movementId is not null (i.e., don't delete a movement that hasn't been inserted)
		if($this->movementId === null) {
			throw(new PDOException("unable to delete a movement that does not exist"));
		}

		// create query template
		$query = "DELETE FROM movement WHERE movementId = :movementId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holder in the template
		$parameters = array("movementId" => $this->movementId);
		$statement->execute($parameters);
	}

	/**
	 * updates this Movement in mySQL
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @throws PDOException when mySQL related errors occur
	 **/
	public function update(PDO &$pdo) {
		// enforce the movementId is not null (i.e., don't update a movement that hasn't been inserted)
		if($this->movementId === null) {
			throw(new PDOException("unable to update a movement that does not exist"));
		}

		// create query template
		$query = "UPDATE movement SET cost = :cost, price = :price WHERE productId = :productId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = array("productId" => $this->productId, "cost" => $this->cost, "price" => $this->price);
		$statement->execute($parameters);
	}

	/**
	 * gets all movements
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @return SplFixedArray all movements found
	 * @throws PDOException when mySQL related errors occur
	 **/
	public static function getAllMovements(PDO &$pdo) {
		// create query template
		$query = "SELECT movementId, fromLocationId, toLocationId, productId, unitId, cost, movementDate, movementType, price FROM profile";
		$statement = $pdo->prepare($query);
		$statement->execute();

		// build an array of movements
		$movements = new SplFixedArray($statement->rowCount());
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$movement = new Movement($row["movementId"], $row["fromLocationId"], $row["toLocationId"], $row["productId"], $row["unitId"], $row["cost"], $row["movementDate"], $row["movementType"], $row["price"]);
				$movements[$movements->key()] = $movement;
				$movements->next();
			} catch(Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($movements);
	}
}