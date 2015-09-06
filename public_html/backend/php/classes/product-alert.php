<?php

/** Class for Product Alert
 *
 * Sets the Products alert level
 * @author Charles Sandidge sandidgec@gmail.com
 **/

class ProductAlert {

	/**
	 * foreign key for alert level
	 * @var int $alertId
	 **/
	private $alertId;

	/**
	 * foreign key for product alert
	 * @var int $productId
	 **/
	private $productId;

	/**
	 * boolean for enabled or disabled alerts in ea product
	 * @var bool $alertEnabled
	 **/
	private $alertEnabled;


	/**
	 * Constructor for productAlert
	 *
	 * @param int $newAlertId  foreign key for alertId in productLevel
	 * @param int $newProductId foreign key for productId in productLevel
	 * @param bool $newAlertEnabled boolean of enabled or disabled alert
	 * @throws InvalidArgumentException is data type is not valid
	 * @throws RangeException if data is not in allowed range
	 * @throws Exception for generic exceptions that are thrown
	 **/
	public function __construct($newAlertId, $newProductId, $newAlertEnabled) {
		try {
			$this->setAlertId($newAlertId);
			$this->setProductId($newProductId);
			$this->setAlertEnabled($newAlertEnabled);
		} catch
		(InvalidArgumentException $invalidArgument) {
			//rethrow the exception to the caller
		} catch
		(RangeException $range) {
			//rethrow the exception to the caller
			throw (new RangeException($range->getMessage(), 0, $range));
		} catch
		(Exception $exception) {
			// rethrow the generic exception
			throw(new Exception($exception->getMessage(), 0, $exception));
		}
	}


	/**
	 * accessor method for product id
	 *
	 * @return int of product id, foreign key for product
	 **/
	public function getProductId() {
		return ($this->productId);
	}

	/**
	 * accessor method for Alert Id
	 *
	 * @return int of Alert Id, foreign key for product
	 */
	public function getAlertId() {
		return ($this->alertId);
	}

	/**
	 * mutator method for Alert Id
	 *
	 * @param int $newAlertId represents foreign key for alert id
	 * @throws InvalidArgumentException for Invalid Alert Id
	 **/
	public function setAlertId($newAlertId) {
		//verify the alert id is valid
		$newAlertId = filter_var($newAlertId, FILTER_VALIDATE_INT);
		if(empty($newAlertId) === true) {
			throw (new InvalidArgumentException ("Alert Id is invalid"));
		}
		$this->alertId = $newAlertId;
	}

	/**
	 * mutator method for Product Id
	 *
	 * @param int $newProductId to represent unique product Id $newProductId
	 * @throws InvalidArgumentException for invalid productId
	 **/
	public function setProductId($newProductId) {
		// verify the Product Id is valid
		if($newProductId === null) {
		$this->productId = null;
			return;
		}
		$newProductId = filter_var($newProductId, FILTER_VALIDATE_INT);
		if(empty($newProductId) === true) {
			throw (new InvalidArgumentException ("Product Id is invalid"));
		}
		$this->productId = $newProductId;
	}

	/**
	 * accessor for Alert Enabled
	 *
	 * @return bool for Alert Enabled on or off
	 **/
	public function isAlertEnabled() {
		return ($this->alertEnabled);
	}

	/**
	 * mutator method Alert Enabled to insure boolean success
	 *
	 * @param bool $newAlertEnabled true or false for enabled or disabled
	 * @throws InvalidArgumentException if alertEnable boolean fails
	 **/
	public function setAlertEnabled($newAlertEnabled) {
		//verify the Alert Enabled is no more than 1 char
		$newAlertEnabled = filter_var($newAlertEnabled, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
		if ($newAlertEnabled === null) {
			throw (new InvalidArgumentException ("alertEnable invalid"));
		}
		$this->alertEnabled = $newAlertEnabled;
	}

	/**
	 * Inserts ProductAlert into mySQL
	 *
	 * Insert PDO
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @throws PDOException for mySQL related issues
	 **/
	public function insert(PDO &$pdo) {
	//create query template
		$query
			= "INSERT INTO productAlert (alertId, productId, alertEnabled)
			VALUES ( :alertId, :productId, :alertEnabled)";
		$statement = $pdo->prepare($query);

		// bind the variables to the place holders in the template
		$parameters = array("alertId" => $this->alertId, "productId" => $this->productId,  "alertEnabled" => $this->alertEnabled);
		$statement->execute($parameters);
	}

	/**
	 * Updates ProductAlert in mySQL
	 *
	 * Update PDO
	 * @param PDO $pdo pointer to the PDO connection, by reference
	 * @throws PDOException for mySQL related issues
	 **/
	public function update (PDO &$pdo) {

	// create query template
	$query = "UPDATE productAlert SET alertEnabled = :alertEnabled WHERE alertId = :alertId AND productId = :productId";
		$statement = $pdo->prepare($query);

		//bind the member variables
		$parameters = array("alertId" => $this->alertId, "productId" => $this->productId,  "alertEnabled" => $this->alertEnabled);
		$statement->execute($parameters);
	}

	/**
	 * deletes this ProductAlert from mySQL
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @throws PDOException when mySQL related errors occur
	 **/
	public function delete(PDO &$pdo) {
		// enforce the ProductId is not null (i.e., don't delete a ProductAlert that hasn't been inserted)
		if($this->productId === null) {
			throw(new PDOException("unable to delete a ProductAlert that does not exist"));
		}

		// create query template
		$query = "DELETE FROM productAlert WHERE productId = :productId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holder in the template
		$parameters = array("productId" => $this->productId);
		$statement->execute($parameters);
	}

	/**
	 * getProductAlertByAlertIdAndProductId
	 *
	 * @param PDO $pdo
	 * @param int $alertId
	 * @param int $productId
	 * @return mixed of ProductAlert
	 * @throws PDOException if alertId is not an integer
	 * @throws PDOException if productId is not an integer
	 * @throws PDOException if alertId is not positive
	 * @throws PDOException if productId is not positive
	 * @throws PDOException if row couldn't be converted in mySQL
	 */
	public static function getProductAlertByAlertIdAndProductId(PDO &$pdo, $alertId, $productId) {
		// sanitize the alertId before searching
		$alertId = filter_var($alertId, FILTER_VALIDATE_INT);
		if($alertId === false) {
			throw(new PDOException("alert Id is not an integer"));
		}
		if($alertId <= 0) {
			throw(new PDOException("alertId is not positive"));
		}

		// sanitize the productId  before searching
		$productId = filter_var($productId, FILTER_VALIDATE_INT);
		if($productId === false) {
			throw(new PDOException("product Id is not an integer"));
		}
		if($productId<= 0) {
			throw(new PDOException("product id is not positive"));
		}

		//create query template
		$query = "SELECT alertId, productId, alertEnabled FROM productAlert WHERE alertId = :alertId AND productId = :productId";
		$statement = $pdo->prepare($query);

		//bind the alertId and productId to the place holder in the template
		$parameters = array("alertId" => $alertId, "productId" => $productId);
		$statement->execute($parameters);

		//grab the productAlert from mySQL
		try {
			$ProductAlert = null;
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$ProductAlert = new ProductAlert ($row["alertId"], $row["productId"], $row["alertEnabled"]);
			}
		} catch (PDOException $exception) {
		// if the row couldn't be converted, rethrow it
		throw(new PDOException($exception->getMessage(), 0, $exception));
		}
		return($ProductAlert);
	}

	/**
	 * getProductAlertByAlertId
	 *
	 * @param PDO $pdo pointer to PDO connection by reference
	 * @param int $alertId
	 * @return mixed ProductAlert
	 * @throws PDOException if alertId is not an integer
	 * @throws PDOException if alertId is not positive
	 * @throws PDOException if row couldn't be converted in mySQL
	 **/
	public static function getProductAlertByAlertId (PDO &$pdo, $alertId) {
	// sanitize the alertId before searching
	$alertId = filter_var($alertId, FILTER_VALIDATE_INT);
	if($alertId === false) {
		throw(new PDOException("alertId is not an integer"));
	}
	if($alertId <= 0) {
		throw(new PDOException("alertId is not positive"));
	}

	//create query template
	$query = "SELECT alertId, productId, alertEnabled FROM productAlert WHERE alertId = :alertId";
	$statement = $pdo->prepare($query);

	//bind the alertId to the place holder in the template
	$parameters = array("alertId" => $alertId);
	$statement->execute($parameters);

	// grab the ProductLevel from mySQL
	try {
		$ProductLevel = null;
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		$row = $statement->fetch();
		if($row !== false) {
			$ProductLevel = new ProductAlert ($row["alertId"], $row["productId"], $row["alertEnabled"]);
		}
	} catch(PDOException $exception) {
		// if the row couldn't be converted rethrow it
		throw(new PDOException($exception->getMessage(), 0, $exception));
	}
	return($ProductLevel);
}

	/**
	 * getProductAlertByProductId
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @param int $productId
	 * @return mixed ProductAlert
	 * @throws PDOException if productId is not an integer
	 * @throws PDOException if productId is not positive
	 **/
	public static function getProductAlertByProductId (PDO &$pdo, $productId) {
		// sanitize the productId before searching
		$productId = filter_var($productId, FILTER_VALIDATE_INT);
		if($productId === false) {
			throw(new PDOException("productId is not an integer"));
		}
		if($productId <= 0) {
			throw(new PDOException("productId is not positive"));
		}

		//create query template
		$query = "SELECT alertId, productId, alertEnabled FROM productAlert WHERE productId = :productId";
		$statement = $pdo->prepare($query);

		//bind the productId to the place holder in the template
		$parameters = array("productId" => $productId);
		$statement->execute($parameters);

// build an array of ProductAlert(s)
		$productAlerts = new SplFixedArray($statement->rowCount());
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$productAlert = new ProductAlert($row["alertId"], $row["productId"], $row["alertEnabled"]);
				$productAlerts[$productAlerts->key()] = $productAlert;
				$productAlerts->next();
			} catch(PDOException $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($productAlerts);
	}

	/**
	 * getProductAlertByAlertEnabled
	 *
	 * @param PDO $pdo
	 * @param $alertEnabled
	 * @return null|ProductAlert
	 * @throws PDOException for invalid Boolean for alert enabled
	 * @throws PDOException if row couldn't be converted in mySQL
	 **/
	public static function getProductAlertByAlertEnabled (PDO &$pdo, $alertEnabled) {
		// sanitize the alertEnabled before searching
		$alertEnabled = filter_var($alertEnabled, FILTER_VALIDATE_BOOLEAN);
		if($alertEnabled === false) {
			throw(new PDOException("alert Enabled is not a valid boolean"));
		}

		//create query template
		$query = "SELECT alertId, productId, alertEnabled FROM productAlert WHERE alertEnabled = :alertEnabled";
		$statement = $pdo->prepare($query);

		//bind the alertEnabled to the place holder in the template
		$parameters = array("alertEnabled" => $alertEnabled);
		$statement->execute($parameters);

		//bind the alertEnabled to the place holder in the template
		$parameters = array("alertEnabled" => $alertEnabled);
		$statement->execute($parameters);

		// grab the ProductAlert from mySQL
		try {
			$ProductAlert = null;
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$ProductLevel = new ProductAlert ($row["alertId"], $row["productId"], $row["alertEnabled"]);
			}
		} catch(PDOException $exception) {
			// if the row couldn't be converted rethrow it
			throw(new PDOException($exception->getMessage(), 0, $exception));
		}
		return($ProductAlert);
	}
}