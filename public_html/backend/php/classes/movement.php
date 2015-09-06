<?php

require_once(dirname(__DIR__) . "/traits/validate-date.php");

/**
 * The movement class for Inventory
 *
 * This class will monitor the movement of products in and
 * out of the inventory as well as the movement within inventory
 *
 * @author Christopher Collopy <ccollopy@cnm.edu>
 **/
class Movement implements JsonSerializable{
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
	 * id for the units of product being moved; this is a foreign key
	 * @var int $unitId
	 **/
	private $unitId;

	/**
	 * id for the user that creates the movement; this is a foreign key
	 * @var int $userId
	 **/
	private $userId;

	/**
	 * cost of the product being moved
	 * @var float $cost
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
	 * @var float $price
	 **/
	private $price;

	use validateDate;

	/**
	 * constructor for this Movement
	 *
	 * @param int $newMovementId id for this Movement
	 * @param int $newFromLocationId id for the product's current location
	 * @param int $newToLocationId id for the product's new location
	 * @param int $newProductId id for the product being moved
	 * @param int $newUnitId id for the units of product being moved
	 * @param int $newUserId id for the user that creates the movement
	 * @param float $newCost the cost of the product being moved
	 * @param DateTime $newMovementDate the date and time of the movement
	 * @param string $newMovementType the type of the movement
	 * @param float $newPrice the price of the product being moved
	 * @throws InvalidArgumentException if data types are not valid
	 * @throws RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws Exception if some other exception is thrown
	 */

	public function __construct($newMovementId, $newFromLocationId, $newToLocationId, $newProductId, $newUnitId,
										 $newUserId, $newCost, $newMovementDate, $newMovementType, $newPrice) {
		try {
			$this->setMovementId($newMovementId);
			$this->setFromLocationId($newFromLocationId);
			$this->setToLocationId($newToLocationId);
			$this->setProductId($newProductId);
			$this->setUnitId($newUnitId);
			$this->setUserId($newUserId);
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
	 * @throws InvalidArgumentException if $newMovementId is not a valid integer
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
	 * @param int $newFromLocationId new value of fromLocationId
	 * @throws InvalidArgumentException if $newFromLocationId is not a valid integer
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
	 * @param int $newToLocationId new value of toLocationId
	 * @throws InvalidArgumentException if $newToLocationId is not a valid integer
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
	 * @param int $newProductId new value of productId
	 * @throws InvalidArgumentException if $newProductId is not a valid integer
	 * @throws RangeException if $newProductId is not positive
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
	 * @param int $newUnitId new value of unitId
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
	 * accessor method for userId
	 *
	 * @return int value of userId
	 */
	public function getUserId() {
		return $this->userId;
	}

	/**
	 * mutator method for userId
	 *
	 * @param int $newUserId new value of userId
	 * @throws InvalidArgumentException if $newUserId is not a valid integer
	 * @throws RangeException if $newUserId is not positive
	 */
	public function setUserId($newUserId) {
		// verify the userId is valid
		$newUserId = filter_var($newUserId, FILTER_VALIDATE_INT);
		if($newUserId === false) {
			throw(new InvalidArgumentException("userId is not a valid integer"));
		}

		// verify the userId is positive
		if($newUserId <= 0) {
			throw(new RangeException("userId is not positive"));
		}

		// convert and store the userId
		$this->userId = intval($newUserId);
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
	 * @param float $newCost new value of cost
	 * @throws InvalidArgumentException if $newCost is not a valid float
	 * @throws RangeException if $newCost is not positive
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
	 * @return DateTime value of movementDate
	 */
	public function getMovementDate() {
		return $this->movementDate;
	}

	/**
	 * mutator method for movementDate
	 *
	 * @param DateTime $newMovementDate new value of movementDate
	 * @throws InvalidArgumentException if $newMovementDate is not a valid DateTime
	 * @throws RangeException if $newMovementDate is what is expected
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
	 * @param string $newMovementType new value of movementType
	 * @throws InvalidArgumentException if $newMovementType is not a string
	 * @throws RangeException if $newMovementType is not 2 character long
	 */
	public function setMovementType($newMovementType) {
		// verify the movementType is secure
		$newMovementType = trim($newMovementType);
		$newMovementType = filter_var($newMovementType, FILTER_SANITIZE_STRING);
		if(empty($newMovementType) === true) {
			throw(new InvalidArgumentException("movementType is empty or insecure"));
		}

		// verify the movementType will fit in the database
		if(strlen($newMovementType) > 2) {
			throw(new RangeException("movementType is too large"));
		}
		if(strlen($newMovementType) < 2) {
			throw(new RangeException("movementType is too small"));
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
	 * @param float $newPrice new value of price
	 * @throws InvalidArgumentException if $newPrice is not a valid float
	 * @throws RangeException if $newPrice is not positive
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
	 * determines which variables to include in json_encode()
	 *
	 * @see http://php.net/manual/en/class.jsonserializable.php JsonSerializable interface
	 * @return array all object variables, including private variables
	 **/
	public function JsonSerialize() {
		$fields = get_object_vars($this);
		$fields["movementDate"] = $this->movementDate->getTimestamp() * 1000;
		return ($fields);
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
		$formattedDate = $this->movementDate->format("Y-m-d H:i:s");
		$query = "INSERT INTO movement(fromLocationId, toLocationId, productId, unitId, userId, cost, movementDate, movementType, price)
 					 VALUES(:fromLocationId, :toLocationId, :productId, :unitId, :userId, :cost, :movementDate, :movementType, :price)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = array("fromLocationId" => $this->fromLocationId, "toLocationId" => $this->toLocationId, "productId" => $this->productId, "unitId" => $this->unitId,
								  "userId" => $this->userId, "cost" => $this->cost, "movementDate" => $formattedDate, "movementType" => $this->movementType, "price" => $this->price);
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
	 * gets the Movement by movementId
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @param int $newMovementId the movementId to search for
	 * @return mixed Movement found or null if not found
	 * @throws PDOException when mySQL related errors occur
	 **/
	public static function getMovementByMovementId(PDO &$pdo, $newMovementId) {
		// sanitize the movementId before searching
		$newMovementId = filter_var($newMovementId, FILTER_VALIDATE_INT);
		if($newMovementId === false) {
			throw(new PDOException("movementId is not an integer"));
		}
		if($newMovementId <= 0) {
			throw(new PDOException("movementId is not positive"));
		}

		// create query template
		$query	 = "SELECT movementId, fromLocationId, toLocationId, productId, unitId, userId, cost, movementDate, movementType, price FROM movement WHERE movementId = :movementId" ;
		$statement = $pdo->prepare($query);

		// bind the movementId to the place holder in the template
		$parameters = array("movementId" => $newMovementId);
		$statement->execute($parameters);

		// grab the movement from mySQL
		try {
			$movement = null;
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$row   = $statement->fetch();
			if($row !== false) {
				$movement = new Movement($row["movementId"], $row["fromLocationId"], $row["toLocationId"], $row["productId"], $row["unitId"], $row["userId"], $row["cost"], $row["movementDate"], $row["movementType"], $row["price"]);
			}
		} catch(Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new PDOException($exception->getMessage(), 0, $exception));
		}
		return($movement);
	}

	/**
	 * gets the Movement by fromLocationId
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @param int $newFromLocationId the fromLocationId to search for
	 * @return mixed Movement(s) found or null if not found
	 * @throws PDOException when mySQL related errors occur
	 **/
	public static function getMovementByFromLocationId(PDO &$pdo, $newFromLocationId) {
		// sanitize the fromLocationId before searching
		$newFromLocationId = filter_var($newFromLocationId, FILTER_VALIDATE_INT);
		if($newFromLocationId === false) {
			throw(new PDOException("fromLocationId is not an integer"));
		}
		if($newFromLocationId <= 0) {
			throw(new PDOException("fromLocationId is not positive"));
		}

		// create query template
		$query	 = "SELECT movementId, fromLocationId, toLocationId, productId, unitId, userId, cost, movementDate, movementType, price FROM movement WHERE fromLocationId = :fromLocationId" ;
		$statement = $pdo->prepare($query);

		// bind the fromLocationId to the place holder in the template
		$parameters = array("fromLocationId" => $newFromLocationId);
		$statement->execute($parameters);

		// build an array of movements
		$movements = new SplFixedArray($statement->rowCount());
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$movement = new Movement($row["movementId"], $row["fromLocationId"], $row["toLocationId"], $row["productId"], $row["unitId"], $row["userId"], $row["cost"], $row["movementDate"], $row["movementType"], $row["price"]);
				$movements[$movements->key()] = $movement;
				$movements->next();
			} catch(Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($movements);
	}

	/**
	 * gets the Movement by toLocationId
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @param int $newToLocationId the toLocationId to search for
	 * @return mixed Movement(s) found or null if not found
	 * @throws PDOException when mySQL related errors occur
	 **/
	public static function getMovementByToLocationId(PDO &$pdo, $newToLocationId) {
		// sanitize the toLocationId before searching
		$newToLocationId = filter_var($newToLocationId, FILTER_VALIDATE_INT);
		if($newToLocationId === false) {
			throw(new PDOException("toLocationId is not an integer"));
		}
		if($newToLocationId <= 0) {
			throw(new PDOException("toLocationId is not positive"));
		}

		// create query template
		$query	 = "SELECT movementId, fromLocationId, toLocationId, productId, unitId, userId, cost, movementDate, movementType, price FROM movement WHERE toLocationId = :toLocationId" ;
		$statement = $pdo->prepare($query);

		// bind the toLocationId to the place holder in the template
		$parameters = array("toLocationId" => $newToLocationId);
		$statement->execute($parameters);

		// build an array of movements
		$movements = new SplFixedArray($statement->rowCount());
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$movement = new Movement($row["movementId"], $row["fromLocationId"], $row["toLocationId"], $row["productId"], $row["unitId"], $row["userId"], $row["cost"], $row["movementDate"], $row["movementType"], $row["price"]);
				$movements[$movements->key()] = $movement;
				$movements->next();
			} catch(Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($movements);
	}

	/**
	 * gets the Movement by fromLocationId & toLocationId
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @param int $newFromLocationId the fromLocationId to search for
	 * @param int $newToLocationId the toLocationId to search for
	 * @return mixed Movement(s) found or null if not found
	 * @throws PDOException when mySQL related errors occur
	 **/
	public static function getMovementByFromLocationIdAndToLocationId(PDO &$pdo, $newFromLocationId, $newToLocationId) {
		// sanitize the fromLocationId before searching
		$newFromLocationId = filter_var($newFromLocationId, FILTER_VALIDATE_INT);
		if($newFromLocationId === false) {
			throw(new PDOException("fromLocationId is not an integer"));
		}
		if($newFromLocationId <= 0) {
			throw(new PDOException("fromLocationId is not positive"));
		}
		// sanitize the toLocationId before searching
		$newToLocationId = filter_var($newToLocationId, FILTER_VALIDATE_INT);
		if($newToLocationId === false) {
			throw(new PDOException("toLocationId is not an integer"));
		}
		if($newToLocationId <= 0) {
			throw(new PDOException("toLocationId is not positive"));
		}

		// create query template
		$query	 = "SELECT movementId, fromLocationId, toLocationId, productId, unitId, userId, cost, movementDate, movementType, price FROM movement WHERE fromLocationId = :fromLocationId AND toLocationId = :toLocationId" ;
		$statement = $pdo->prepare($query);

		// bind the toLocationId to the place holder in the template
		$parameters = array("fromLocationId" => $newFromLocationId, "toLocationId" => $newToLocationId);
		$statement->execute($parameters);

		// build an array of movements
		$movements = new SplFixedArray($statement->rowCount());
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$movement = new Movement($row["movementId"], $row["fromLocationId"], $row["toLocationId"], $row["productId"], $row["unitId"], $row["userId"], $row["cost"], $row["movementDate"], $row["movementType"], $row["price"]);
				$movements[$movements->key()] = $movement;
				$movements->next();
			} catch(Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($movements);
	}

	/**
	 * gets the Movement by productId
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @param int $newProductId the productId to search for
	 * @return mixed Movement(s) found or null if not found
	 * @throws PDOException when mySQL related errors occur
	 **/
	public static function getMovementByProductId(PDO &$pdo, $newProductId) {
		// sanitize the productId before searching
		$newProductId = filter_var($newProductId, FILTER_VALIDATE_INT);
		if($newProductId === false) {
			throw(new PDOException("productId is not an integer"));
		}
		if($newProductId <= 0) {
			throw(new PDOException("productId is not positive"));
		}

		// create query template
		$query	 = "SELECT movementId, fromLocationId, toLocationId, productId, unitId, userId, cost, movementDate, movementType, price FROM movement WHERE productId = :productId" ;
		$statement = $pdo->prepare($query);

		// bind the productId to the place holder in the template
		$parameters = array("productId" => $newProductId);
		$statement->execute($parameters);

		// build an array of movements
		$movements = new SplFixedArray($statement->rowCount());
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$movement = new Movement($row["movementId"], $row["fromLocationId"], $row["toLocationId"], $row["productId"], $row["unitId"], $row["userId"], $row["cost"], $row["movementDate"], $row["movementType"], $row["price"]);
				$movements[$movements->key()] = $movement;
				$movements->next();
			} catch(Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($movements);
	}

	/**
	 * gets the Movement by userId
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @param int $newUserId the userId to search for
	 * @return mixed Movement(s) found or null if not found
	 * @throws PDOException when mySQL related errors occur
	 **/
	public static function getMovementByUserId(PDO &$pdo, $newUserId) {
		// sanitize the userId before searching
		$newUserId = filter_var($newUserId, FILTER_VALIDATE_INT);
		if($newUserId === false) {
			throw(new PDOException("userId is not an integer"));
		}
		if($newUserId <= 0) {
			throw(new PDOException("userId is not positive"));
		}

		// create query template
		$query	 = "SELECT movementId, fromLocationId, toLocationId, productId, unitId, userId, cost, movementDate, movementType, price FROM movement WHERE userId = :userId" ;
		$statement = $pdo->prepare($query);

		// bind the userId to the place holder in the template
		$parameters = array("userId" => $newUserId);
		$statement->execute($parameters);

		// build an array of movements
		$movements = new SplFixedArray($statement->rowCount());
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$movement = new Movement($row["movementId"], $row["fromLocationId"], $row["toLocationId"], $row["productId"], $row["unitId"], $row["userId"], $row["cost"], $row["movementDate"], $row["movementType"], $row["price"]);
				$movements[$movements->key()] = $movement;
				$movements->next();
			} catch(Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($movements);
	}

	/**
	 * gets the Movement by movementDate
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @param DateTime $newMovementDate the movementDate to search for
	 * @return mixed Movement(s) found or null if not found
	 * @throws PDOException when mySQL related errors occur
	 **/
	public static function getMovementByMovementDate(PDO &$pdo, $newMovementDate) {
		// sanitize the movementDate before searching
		try {
			$newMovementDate = validateDate::validateDate($newMovementDate);
		} catch(InvalidArgumentException $invalidArgument) {
			throw(new InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(RangeException $range) {
			throw(new RangeException($range->getMessage(), 0, $range));
		}

		$sunrise = $newMovementDate->format("Y-m-d") . " 00:00:00";
		$sunset = $newMovementDate->format("Y-m-d") . " 23:59:59";

		// create query template
		$query	 = "SELECT movementId, fromLocationId, toLocationId, productId, unitId, userId, cost, movementDate, movementType, price FROM movement WHERE movementDate >= :sunrise AND movementDate <= :sunset" ;
		$statement = $pdo->prepare($query);

		// bind the movementDate to the place holder in the template
		$parameters = array("sunrise" => $sunrise, "sunset" => $sunset);
		$statement->execute($parameters);

		// build an array of movements
		$movements = new SplFixedArray($statement->rowCount());
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$movement = new Movement($row["movementId"], $row["fromLocationId"], $row["toLocationId"], $row["productId"], $row["unitId"], $row["userId"], $row["cost"], $row["movementDate"], $row["movementType"], $row["price"]);
				$movements[$movements->key()] = $movement;
				$movements->next();
			} catch(Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($movements);
	}

	/**
	 * gets the Movement by movementType
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @param string $newMovementType the movementType to search for
	 * @return mixed Movement(s) found or null if not found
	 * @throws PDOException when mySQL related errors occur
	 **/
	public static function getMovementByMovementType(PDO &$pdo, $newMovementType) {
		// sanitize the movementType before searching
		$newMovementType = trim($newMovementType);
		$newMovementType = filter_var($newMovementType, FILTER_SANITIZE_STRING);
		if(empty($newMovementType) === true) {
			throw(new InvalidArgumentException("movementType is empty or insecure"));
		}

		// verify the movementType will fit in the database
		if(strlen($newMovementType) > 2) {
			throw(new RangeException("movementType is too large"));
		}
		if(strlen($newMovementType) < 2) {
			throw(new RangeException("movementType is too small"));
		}

		// create query template
		$query	 = "SELECT movementId, fromLocationId, toLocationId, productId, unitId, userId, cost, movementDate, movementType, price FROM movement WHERE movementType = :movementType" ;
		$statement = $pdo->prepare($query);

		// bind the movementType to the place holder in the template
		$parameters = array("movementType" => $newMovementType);
		$statement->execute($parameters);

		// build an array of movements
		$movements = new SplFixedArray($statement->rowCount());
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$movement = new Movement($row["movementId"], $row["fromLocationId"], $row["toLocationId"], $row["productId"], $row["unitId"], $row["userId"], $row["cost"], $row["movementDate"], $row["movementType"], $row["price"]);
				$movements[$movements->key()] = $movement;
				$movements->next();
			} catch(Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($movements);
	}

	/**
	 * gets all movements
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @param int $page the page of results the viewer is on
	 * @return SplFixedArray all movements found
	 * @throws PDOException when mySQL related errors occur
	 **/
	public static function getAllMovements(PDO &$pdo, $page) {
		// number of results per page
		$page = filter_var($page, FILTER_VALIDATE_INT);
		$pageSize = 25;
		$start = $page * $pageSize;

		// create query template
		$query = "SELECT movementId, fromLocationId, toLocationId, productId, unitId, userId, cost, movementDate,
					 movementType, price FROM movement ORDER BY movementDate LIMIT :start, :pageSize";
		$statement = $pdo->prepare($query);
		$statement->bindParam(":start", $start, PDO::PARAM_INT);
		$statement->bindParam(":pageSize", $pageSize, PDO::PARAM_INT);
		$statement->execute();

		// build an array of movements
		$movements = new SplFixedArray($statement->rowCount());
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$movement = new Movement($row["movementId"], $row["fromLocationId"], $row["toLocationId"], $row["productId"], $row["unitId"], $row["userId"], $row["cost"], $row["movementDate"], $row["movementType"], $row["price"]);
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