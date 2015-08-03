<?php
/**
 * product_permissions class for foodinventory
 *
 * This product permissions class is a single class within the overall foodinventory application
 *
 * @author Marie Vigil <marie@jtdesignsolutions>
 *
 **/


class productPermissions {
	/**
	 * id for the product related to this Permission; this is a foreign key
	 * @var int $productId
	 **/
	private $productId;
	/**
	 * id for the user of this product; this is a foreign key
	 * @var int $userId
	 **/
	private $userId;
	/**
	 * access level of this product
	 * @var string $accessLevel
	 **/
	private $accessLevel;

	/**
	 * constructor for this productPermissions
	 *
	 * @param int $newProductId id for the related product
	 * @param int $newUserId id for the user
	 * @param int $newAccessLevel access level of this permission
	 * @throws InvalidArgumentException if data types are not valid
	 * @throws RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws Exception if some other exception is thrown
	 */

	public function __construct($newProductId, $newUserId, $newAccessLevel) {
		try {
			$this->setProductId($newProductId);
			$this->setUserId($newUserId);
			$this->setAccessLevel($newAccessLevel);
		} catch(InvalidArgumentException $invalidArgument) {
			// rethrow the exception to the caller
			throw(new InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(RangeException $range) {
			// rethrow the exception to the caller
			throw(new RangeException($range->getMessage(), 0, $range));
		} catch(Exception $exception) {
			// rethrow generic exception
			throw(new Exception($exception->getMessage(), 0, $exception));
		}
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
	 * @param int $newUserId
	 */
	public function setUserId($newUserId) {
		// verify the unitId is valid
		$newUserId = filter_var($newUserId, FILTER_VALIDATE_INT);
		if($newUserId === false) {
			throw(new InvalidArgumentException("userId is not a valid integer"));
		}

		// verify the unitId is positive
		if($newUserId <= 0) {
			throw(new RangeException("userId is not positive"));
		}

		// convert and store the unitId
		$this->userId = intval($newUserId);
	}

	/**
	 * accessor method for accessLevel
	 *
	 * @return int value of accessLevel
	 **/
	public function getAccessLevel() {
		return($this->accessLevel);
	}


	/**
	 * mutator method for accessLevel
	 *
	 * @param int $newAccessLevel
	 */
	public function setAccessLevel($newAccessLevel) {
		// verify the accessLevel is valid
		$newAccessLevel = filter_var($newAccessLevel, FILTER_VALIDATE_INT);
		if($newAccessLevel === false) {
			throw(new InvalidArgumentException("accessLevel is not a valid integer"));
		}

		// verify the accessLevel is positive
		if($newAccessLevel <= 0) {
			throw(new RangeException("accessLevel is not positive"));
		}

		// convert and store the unitId
		$this->accessLevel = intval($newAccessLevel);
	}


	/**
	 * inserts this accessLevel into mySQL
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @throws PDOException when mySQL related errors occur
	 **/
	public function insert(PDO &$pdo) {
		// create query template
		$query	 = "INSERT INTO productPermissions(productId, userId, accessLevel) VALUES(:productId, :userId, :accessLevel)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = array("productId" => $this->productId, "userId" => $this->userId, "accessLevel" => accessLevel);
		$statement->execute($parameters);
	}

	/**
	 * gets all productPermissions
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @return SplFixedArray all productPermissions found
	 * @throws PDOException when mySQL related errors occur
	 **/
	public static function getAllProductPermissions(PDO &$pdo) {
		// create query template
		$query = "SELECT userId, productId, accessLevel FROM productPermissions";
		$statement = $pdo->prepare($query);
		$statement->execute();

		// build an array of productPermissions
		$permissions = new SplFixedArray($statement->rowCount());
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$permission = new productPermissions($row["userId"], $row["productId"], $row["accessLevel"]);
				$permissions[$permissions->key()] = $permission;
				$permissions->next();
			} catch(Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($permissions);
	}

?>