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
	 * id for this productPermissions; this is the primary key
	 * @var int $productPermissionsId
	 **/
	private $productPermissionsId;
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
	 * @param int $newProductPermissionsId id for this permission
	 * @param int $newProductId id for the related product
	 * @param int $newUserId id for the user
	 * @param int $newAccessLevel access level of this permission
	 * @throws InvalidArgumentException if data types are not valid
	 * @throws RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws Exception if some other exception is thrown
	 */

	public function __construct($newProductPermissionsId, $newProductId, $newUserId, $newAccessLevel) {
		try {
			$this->setProductPermissionsId($newProductPermissionsId);
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
	 * accessor method for productPermissionsId
	 *
	 * @return int value of productPermissionsId
	 **/
	public function getProductPermissionsId() {
		return $this->productPermissionsId;
	}

	/**
	 * mutator method for productPermissionsId
	 *
	 * @param int $newProductPermissionsId new value of productPermissions Id
	 * @throws InvalidArgumentException if $newProductPermissionsId is not an integer
	 * @throws RangeException if $newProductPermissionsId is not positive
	 **/
	public function setProductPermissionsId($newProductPermissionsId) {
		// if the ProductPermissionsId is null, then a new permission without a mySQL assigned id
		if($newProductPermissionsId === null) {
			$this->productPermissionsId = null;
			return;
		}

		// verify the productPermissions id is valid
		$newProductPermissionsId = filter_var($newProductPermissionsId, FILTER_VALIDATE_INT);
		if($newProductPermissionsId === false) {
			throw(new InvalidArgumentException("productPermission id is not a valid integer"));
		}

		// verify the productPermissions id is positive
		if($newProductPermissionsId <= 0) {
			throw(new RangeException("productPermission id is not positive"));
		}

		// convert and store the productPermissions id
		$this->productPermissionsId = intval($newProductPermissionsId);
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
		$query	 = "INSERT INTO productPermissions(productPermissionsId, productId, userId, accessLevel) VALUES(:productPermissionsId, :productId, :userId, :accessLevel)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = array("productPermissionsId" => $this->productPermissionsId, "productId" => $this->productId, "userId" => $this->userId, "accessLevel" => accessLevel);
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
		$query	 = "DELETE FROM productPermissions WHERE productPermissionsId = :productPermissionsId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holder in the template
		$parameters = array("productPermissionsId" => $this->productPermissionsId);
		$statement->execute($parameters);
	}



	/**
	 * updates this productPermissions in mySQL
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @throws PDOException when mySQL related errors occur
	 **/
	public function update(PDO &$pdo) {
		// enforce the productPermissionsId is not null (i.e., don't update a permission that hasn't been inserted)
		if($this->productPermissionsId === null) {
			throw(new PDOException("unable to update a permission that does not exist"));
		}

		// create query template
		$query	 = "UPDATE productPermissions SET accessLevel = :accessLevel WHERE productPermissionsId = :productPermissionsId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = array("productPermissionsId" => $this->productPermissionsId, "accessLevel" => $this->accessLevel);
		$statement->execute($parameters);
	}



	/**
	 * gets the productPermissions by productPermissionsId
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @param int $productPermissionsId permission id to search for
	 * @return mixed permission found or null if not found
	 * @throws PDOException when mySQL related errors occur
	 **/
	public static function getPermissionByProductPermissionId(PDO &$pdo, $productPermissionsId) {
		// sanitize the productPermissionsId before searching
		$productPermissionsId = filter_var($productPermissionsId, FILTER_VALIDATE_INT);
		if($productPermissionsId === false) {
			throw(new PDOException("productPermissions id is not an integer"));
		}
		if($productPermissionsId <= 0) {
			throw(new PDOException("productPermissions id is not positive"));
		}

		// create query template
		$query	 = "SELECT productPermissionsId, userId, productId, accessLevel FROM productPermissions WHERE productPermissionsId = :productPermissionsId";
		$statement = $pdo->prepare($query);

		// bind the productPermissions id to the place holder in the template
		$parameters = array("productPermissionsId" => $productPermissionsId);
		$statement->execute($parameters);

		// grab the productPermissions from mySQL
		try {
			$permission = null;
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$row   = $statement->fetch();
			if($row !== false) {
				$permission = new productPermissions($row["productPermissionsID"], $row["userId"], $row["productId"], $row["accessLevel"]);
			}
		} catch(Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new PDOException($exception->getMessage(), 0, $exception));
		}
		return($permission);
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
		$query = "SELECT productPermissionsId, userId, productId, accessLevel FROM productPermissions";
		$statement = $pdo->prepare($query);
		$statement->execute();

		// build an array of tweets
		$permissions = new SplFixedArray($statement->rowCount());
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$permission = new Tweet($row["productPermissionsId"], $row["userId"], $row["productId"], $row["accessLevel"]);
				$permissions[$permissions->key()] = $permission;
				$permissions->next();
			} catch(Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($permissions);
	}


?>