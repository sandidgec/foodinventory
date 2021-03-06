<?php


/**
 * Class for Location
 *
 * This class describes where an item in inventory is physically located
 *
 * The class to handle location
 * @author Charles Sandidge sandidgec@gmail.com
 **/
class Location implements JsonSerializable {

	/**
	 * primary key for location
	 * @var int for the unique location id  $locationId
	 **/
	private $locationId;

	/**
	 * storageCode
	 * short description of location for storage (i.e. BR (backroom))
	 * @var string of the storage code  $storageCode
	 **/
	private $storageCode;

	/**
	 * description
	 * @var string of the location description $description
	 **/
	private $description;


	/**
	 * Constructor for location class
	 *
	 * @param int of the unique location Id $newLocationId
	 * @param string of the locations unique storage code $newStorageCode
	 * @param string of the locations description $newDescription
	 * @throws Exception for other exceptions
	 * @throws RangeException if data values are out of range
	 **/
	public function __construct($newLocationId, $newStorageCode, $newDescription) {
		try {
			$this->setLocationId($newLocationId);
			$this->setStorageCode($newStorageCode);
			$this->setDescription($newDescription);
		} catch
		(InvalidArgumentException $invalidArgument) {
			//rethrow the exception to the caller
			throw(new InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch
		(RangeException $range) {
			// rethrow the exception to the caller
			throw (new RangeException($range->getMessage(), 0, $range));
		} catch(Exception $exception) {
			// rethrow generic exception
			throw(new Exception($exception->getMessage(), 0, $exception));
		}
	}


	/**
	 * accessor method for location id
	 *
	 * @return int for location id
	 **/
	public function getLocationId() {
		return ($this->locationId);
	}

	/**
	 * Mutator method for LocationId
	 *
	 * @param int of the location id $newLocationId
	 * @throws InvalidArgumentException for invalid locationId
	 **/
	public function setLocationId($newLocationId) {
		// base case: if the locationId is null,
		// this is a new location without a mySQL assigned id (yet)
		if($newLocationId === null) {
			$this->locationId = null;
			return;
		}
		//verify the locationId is valid
		$newLocationId = filter_var($newLocationId, FILTER_VALIDATE_INT);
		if(empty($newLocationId) === true) {
			throw (new InvalidArgumentException ("Location Id invalid"));
		}
		$this->locationId = $newLocationId;
	}

	/**
	 * accessor method for storage code
	 * @return string for storage code
	 **/
	public function getStorageCode() {
		return ($this->storageCode);
	}

	/**
	 * mutator method for Storage Code
	 *
	 * @param string of the storage code $newStorageCode
	 * @throws InvalidArgumentException for invalid storage code
	 **/
	public function setStorageCode($newStorageCode) {
		//verify the storage code is valid
		$newStorageCode = trim($newStorageCode);
		$newStorageCode = filter_var($newStorageCode, FILTER_SANITIZE_STRING);
		if(empty($newStorageCode) === true) {
			throw (new InvalidArgumentException ("storage code is an invalid string"));
		}
		$this->storageCode = $newStorageCode;
	}

	/**
	 * accessor method for Description
	 *
	 * @return string for description
	 **/
	public function getDescription() {
		return ($this->description);
	}

	/**
	 * mutator method for description
	 *
	 * @param string of the location description $newDescription
	 * @throws InvalidArgumentException for invalid string
	 **/
	public function setDescription($newDescription) {
		//verify the description is valid
		$newDescription = filter_var($newDescription, FILTER_SANITIZE_STRING);
		if(empty($newDescription) === true) {
			throw (new InvalidArgumentException ("description invalid"));
		}
		$this->description = $newDescription;
	}

	public function JsonSerialize() {
		$fields = get_object_vars($this);
		return ($fields);
	}

	/**
	 * inserts location into mySQL
	 *
	 * insert PDO
	 * @param PDO $pdo pointer to PDO connection , by reference
	 * @throws PDOException for mySQL related issues
	 **/
	public function insert(PDO &$pdo) {
		// make sure location id doesn't already exist
		if($this->locationId !== null) {
			throw (new PDOException("existing locationId"));
		}
		//create query template
		$query
			= "INSERT INTO location(locationId, storageCode, description)
		VALUES (:locationId, :storageCode, :description)";
		$statement = $pdo->prepare($query);

		// bind the variables to the place holders in the template
		$parameters = array("locationId" => $this->locationId, "storageCode" => $this->storageCode,
			"description" => $this->description);

		$statement->execute($parameters);

		//update null userId with what mySQL just gave us
		$this->locationId = intval($pdo->lastInsertId());
	}

	/**
	 * delete pdo
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @throws PDOException for mySQL related issues
	 **/
	public function delete(PDO &$pdo) {
		// enforce the locationId is not null
		if($this->locationId === null) {
			throw(new PDOException("unable to delete a locationId that does not exist"));
		}

		//create query template
		$query = "DELETE FROM location WHERE locationId = :locationId";
		$statement = $pdo->prepare($query);

		//bind the member variables to the place holder in the template
		$parameters = array("locationId" => $this->locationId);
		$statement->execute($parameters);
	}

	/**
	 * update location in mySQL
	 *
	 * update PDO
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @throws PDOException for mySQL related issues
	 **/
	public function update(PDO &$pdo) {
		if($this->locationId === null) {
			throw (new PDOException("can't update location that hasn't been saved"));
		}

		// create query template
		$query = "UPDATE location SET storageCode = :storageCode, description = :description WHERE locationId = :locationId";
		$statement = $pdo->prepare($query);

		// bind the member variables
		$parameters = array("storageCode" => $this->storageCode, "description" => $this->description, "locationId" => $this->locationId);
		$statement->execute($parameters);

	}


	/**
	 * get location by location Id
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @param int of the location id $locationId
	 * @return mixed info for the location $location
	 **/
	public static function getLocationByLocationId(PDO &$pdo, $locationId) {
		// sanitize the location id before searching
		$locationId = filter_var($locationId, FILTER_VALIDATE_INT);
		if($locationId === false) {
			throw(new PDOException("location id is not an integer"));
		}
		if($locationId <= 0) {
			throw(new PDOException("location id is not positive"));
		}

		// create query template
		$query = "SELECT locationId, storageCode, description FROM location WHERE locationId = :locationId";
		$statement = $pdo->prepare($query);

		// bind the location id to the place holder in the template
		$parameters = array("locationId" => $locationId);
		$statement->execute($parameters);

		// grab the location from mySQL
		try {
			$location = null;
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$location = new Location ($row["locationId"], $row["storageCode"], $row["description"]);
			}
		} catch(Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new PDOException($exception->getMessage(), 0, $exception));
		}
		return ($location);
	}


	/**
	 * get Location by Storage Code
	 *
	 * @param PDO $pdo connection to PDO, by reference
	 * @param string info for storage code $storageCode
	 * @return mixed info for the Location | null
	 **/
	public static function getLocationByStorageCode(PDO &$pdo, $storageCode) {
		// sanitize the storageCode before searching
		$storageCode = filter_var($storageCode, FILTER_SANITIZE_STRING);
		if($storageCode === false) {
			throw(new PDOException("storage code is not valid"));
		}
		// create query template
		$query = "SELECT locationId, storageCode, description FROM location WHERE storageCode = :storageCode";
		$statement = $pdo->prepare($query);

		// bind the location id to the place holder in the template
		$parameters = array("storageCode" => $storageCode);
		$statement->execute($parameters);

		// grab the user from mySQL
		try {
			$location = null;
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$location = new Location ($row["locationId"], $row["storageCode"], $row["description"]);
			}
		} catch(Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new PDOException($exception->getMessage(), 0, $exception));
		}
		return ($location);
	}


	public static function getProductByLocationId(PDO &$pdo, $newLocationId) {
		// sanitize the alertId before searching
		$newLocationId = filter_var($newLocationId, FILTER_VALIDATE_INT);
		if(empty($newLocationId) === true) {
			throw(new PDOException("productId is an invalid integer"));
		}
		$query = "SELECT product.productId, product.vendorId, product.description AS productDescription, product.leadTime, product.sku, product.title,
					location.locationId, location.storageCode, location.description AS locationDescription
					FROM productLocation
					INNER JOIN location ON location.locationId = productLocation.locationId
					INNER JOIN product ON product.productId = productLocation.productId
					WHERE location.locationId = :locationId";
		$statement = $pdo->prepare($query);

		// bind the locationId to the place holder in the template
		$parameters = array("locationId" => $newLocationId);
		$statement->execute($parameters);

		// build an array of Products and an associated alertLevel
		$products = new SplFixedArray($statement->rowCount() + 1);
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				if($products->key() === 0) {
					$location = new Location($row["locationId"], $row["storageCode"], $row["locationDescription"]);
					$products[$products->key()] = $location;
					$products->next();
				}
				$product = new Product($row["productId"], $row["vendorId"], $row["productDescription"], $row["leadTime"], $row["sku"], $row["title"]);
				$products[$products->key()] = $product;
				$products->next();
			} catch(PDOException $exception) {
				//if the row couldn't be converted, rethrow it
				throw(new PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($products);
	}



		/**
		 *  Get all Locations
		 * @param PDO $pdo pointer to PDO connection, by reference
		 * @return mixed|location
		 **/
		public
		static function getAllLocations(PDO &$pdo) {

			// create query template
			$query = "SELECT locationId, storageCode, description FROM location";
			$statement = $pdo->prepare($query);
			$statement->execute();

			// build an array of movements
			$locations = new SplFixedArray($statement->rowCount());
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			while(($row = $statement->fetch()) !== false) {
				try {
					$location = new Location($row["locationId"],$row["storageCode"], $row["description"]);
					$locations[$locations->key()] = $location;
					$locations->next();
				} catch(Exception $exception) {
					// if the row couldn't be converted, rethrow it
					throw(new PDOException($exception->getMessage(), 0, $exception));
				}
			}
			return($locations);
		}
}




