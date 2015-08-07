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
	 * @param str $newAccessLevel access level of this permission
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
	 * accessor method for ProductId
	 *
	 * @return int value of ProductId
	 */
	public function getProductId() {
		return $this->productId;
	}


	/**
	 * mutator method for productId
	 *
	 * @param int $newProductId
	 * @throws InvalidArgumentException if $newProductId is not an integer
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
	 * @throws InvalidArgumentException if $newUserId is not an integer
	 * @throws RangeException if $newUserId is not positive
	 **/
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
	 *
	 * @return string value of accessLevel
	 **/
	public function getAccessLevel() {
		return ($this->accessLevel);
	}

	/**
	 * mutator method for accessLevel
	 *
	 * @param string $newAccessLevel new value of accessLevel
	 * @throws InvalidArgumentException if $newAccessLevel is not a string or insecure
	 * @throws RangeException if $newAccessLevel is > 128 characters
	 **/
	public function setAccessLevel($newAccessLevel) {
		// verify the accessLevel is secure
		$newAccessLevel = trim($newAccessLevel);
		$newAccessLevel = filter_var($newAccessLevel, FILTER_SANITIZE_STRING);
		if(empty($newAccessLevel) === true) {
			throw(new InvalidArgumentException("accessLevel is empty or insecure"));
		}

		// verify the accessLevel will fit in the database
		if(strlen($newAccessLevel) > 128) {
			throw(new RangeException("description too large"));
		}

		// store the accessLevel
		$this->accessLevel = $newAccessLevel;
	}

	/**
	 * inserts this productPermissions into mySQL
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @throws PDOException when mySQL related errors occur
	 **/
	public function insert(PDO &$pdo) {
		// create query template
		$query = "INSERT INTO productPermissions(productId, userId, accessLevel) VALUES(:productId, :userId, :accessLevel)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = array("productId" => $this->productId, "userId" => $this->userId, "accessLevel" => accessLevel);
		$statement->execute($parameters);
	}

	/**
	 * deletes this productPermissions from mySQL
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @throws PDOException when mySQL related errors occur
	 **/
	public function delete(PDO &$pdo) {
		// enforce the productPermissionsId is not null (i.e., don't delete a permission that hasn't been inserted)
		if($this->productPermissionsId === null) {
			throw(new PDOException("unable to delete a permission that does not exist"));
		}

		// create query template
		$query = "DELETE FROM productPermissions WHERE userId = :userId AND productId = :productId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = array("userId" => $this->userId, "productId" => $this->productId);
		$statement->execute($parameters);
	}


	/**
	 * updates this productPermissions in mySQL
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @throws PDOException when mySQL related errors occur
	 **/
	public function update(PDO &$pdo) {

		// create query template
		$query = "UPDATE productPermissions SET accessLevel = :accessLevel WHERE userId = :userId AND productId = :productId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = array("accessLevel" => $this->accessLevel, "userId" => $this->userId, "productId" => $this->productId);
		$statement->execute($parameters);
	}

	/**
	 * gets the productPermissions by productId
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @param int $productId product id to search for
	 * @return mixed productPermissions found or null if not found
	 * @throws PDOException when mySQL related errors occur
	 **/
	public static function getProductPermissionsByProductId(PDO &$pdo, $newProductId) {
		// sanitize the userId before searching
		$newProductId = filter_var($newProductId, FILTER_VALIDATE_INT);
		if($newProductId === false) {
			throw(new PDOException("product id is not an integer"));
		}
		if($newProductId <= 0) {
			throw(new PDOException("product id is not positive"));
		}

		// create query template
		$query = "SELECT userId, productId, accessLevel FROM productPermissions WHERE productId = :productId";
		$statement = $pdo->prepare($query);

		// bind the product id to the place holder in the template
		$parameters = array("productId" => $newProductId);
		$statement->execute($parameters);

		// grab the productPermissions from mySQL
		try {
			$productPermissions = null;
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$productPermissions = new ProductPermissions($row["userId"], $row["productId"], $row["accessLevel"]);
			}
		} catch(Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new PDOException($exception->getMessage(), 0, $exception));
		}
		return ($productPermissions);
	}


	/**
	 * gets the productPermissions by userId
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @param int $userId user id to search for
	 * @return mixed productPermissions found or null if not found
	 * @throws PDOException when mySQL related errors occur
	 **/
	public static function getProductPermissionsByUserId(PDO &$pdo, $newUserId) {
		// sanitize the userId before searching
		$newUserId = filter_var($newUserId, FILTER_VALIDATE_INT);
		if($newUserId === false) {
			throw(new PDOException("user id is not an integer"));
		}
		if($newUserId <= 0) {
			throw(new PDOException("user id is not positive"));
		}

		// create query template
		$query = "SELECT userId, productId, accessLevel FROM productPermissions WHERE userId = :userId";
		$statement = $pdo->prepare($query);

		// bind the user id to the place holder in the template
		$parameters = array("userId" => $newUserId);
		$statement->execute($parameters);

		// grab the productPermissions from mySQL
		try {
			$productPermissions = null;
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$productPermissions = new ProductPermissions($row["userId"], $row["productId"], $row["accessLevel"]);
			}
		} catch(Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new PDOException($exception->getMessage(), 0, $exception));
		}
		return ($productPermissions);
	}


	/*
	* Every Product Permissions has a unique constraint with 1 user id in the database.
	* I want to fill data into the "Product Permissions"-object with PDOs
	* "FETCH_CLASS" method which works for all the "Product Permissions"


$statement = $db -> prepare($query);
$statement -> execute();
$statement -> setFetchMode(PDO::FETCH_CLASS, 'UserId');
$userId = $statement -> fetchAll();

		*/


	/**
	 * gets the product by accessLevel
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @param string $accessLevel product content to search for
	 * @return SplFixedArray all product found for this accessLevel
	 * @throws PDOException when mySQL related errors occur
	 **/
	public static function getProductByAccessLevel(PDO &$pdo, $newAccessLevel, $accessLevel) {
		// sanitize the accessLevel before searching
		$newAccessLevel = trim($newAccessLevel);
		$newAccessLevel = filter_var($newAccessLevel, FILTER_SANITIZE_STRING);
		if(empty($newAccessLevel) === true) {
			throw(new PDOException("accessLevel is invalid"));
		}

		// create query template
		$query = "SELECT productId, vendorId, sku, leadTime, title, description FROM product WHERE accessLevel LIKE :accessLevel";
		$statement = $pdo->prepare($query);

		// bind the accessLevel to the place holder in the template
		$parameters = array("accessLevel" => $accessLevel);
		$statement->execute($parameters);

		// build an array of products
		$products = new SplFixedArray($statement->rowCount());
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$productPermissions = null;
				$statement->setFetchMode(PDO::FETCH_ASSOC);
				$row = $statement->fetch();
				if($row !== false) {
					$productPermissions = new ProductPermissions($row["userId"], $row["productId"], $row["accessLevel"]);
				}
			} catch(Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new PDOException($exception->getMessage(), 0, $exception));
			}
			return ($productPermissions);
		}
	}

}