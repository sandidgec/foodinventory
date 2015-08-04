<?php

class Location {

	/**
	 * @var int $locationId
	 */
	private $locationId;

	/**
	 * @var int $storageCode
	 *
	 */
	private $storageCode;

	/**
	 * @var string $description
	 */
	private $description;

	/**
	 * Constructor for Location Class
	 * @param $newLocationId
	 * @param $newStorageCode
	 * @param $newDescription
	 */
public function __construct($newLocationId, $newStorageCode, $newDescription) {
try {
	$this->setLocationId($newLocationId);
	$this->setStorageCode($newStorageCode);
	$this->setDescription($newDescription);
} catch
(InvalidArgumentException $invalidArgument) {
	//rethrow the exception to the caller
	throw(new InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
	}
}

	/**
	 * accessor for location id
	 * @return int
	 */
	public function getLocationId() {
		return ($this->locationId);
}

	/**
	 * Mutator for LocationId
	 * @param $newLocationId
	 */
	public function setLocationId($newLocationId) {
		//verify the locationId is valid
		$newLocationId = filter_var($newLocationId, FILTER_VALIDATE_INT);
		if(empty($newUserId) === true) {
			throw (new InvalidArgumentException ("content invalid"));
		}
		$this->locationId = $newLocationId;
	}
	/**
	 * accessor for storage code
	 * @return int
	 */
	public function getStorageCode() {
		return ($this->storageCode);
	}

	/**
	 * mutator for Storage Code
	 * @param $newStorageCode
	 */
	public function setStorageCode($newStorageCode) {
		//verify the storage code is valid
		$newStorageCode = filter_var($newStorageCode, FILTER_VALIDATE_INT);
		if(empty($newStorageCode) === true) {
			throw (new InvalidArgumentException ("content invalid"));
		}
		$this->storageCode = $newStorageCode;
	}
	/**
	 * accessor for Description
	 * @return string
	 */
	public function getDescription() {
		return ($this->description);
	}

	/**
	 * mutator for description
	 * @param $newDescription
	 */
	public function setDescription($newDescription) {
		//verify the User is valid
		$newDescription = filter_var($newDescription, FILTER_SANITIZE_STRING);
		if(empty($newDescription) === true) {
			throw (new InvalidArgumentException ("content invalid"));
		}
		$this->description = $newDescription;
	}

	/**
	 * insert PDO
	 * @param PDO $pdo
	 */
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
	 * @param PDO $pdo
	 */
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
	 * update PDO
	 * @param PDO $pdo
	 */
	public function update(PDO &$pdo) {

		// create query template
		$query	 = "UPDATE location SET storageCode = :storageCode, description = :description WHERE locationId = :locationId";
		$statement = $pdo->prepare($query);

		// bind the member variables
		$parameters = array("storageCode" => $this->storageCode, "description" => $this->description, "locationId" => $this->locationId);
		$statement->execute($parameters);
	}


	/**
	 * get location by location Id
	 * @param PDO $pdo
	 * @param $locationId
	 * @return mixed
	 */
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

		// bind the user id to the place holder in the template
		$parameters = array("locationId" => $locationId);
		$statement->execute($parameters);

		// grab the location from mySQL
		try {
			$location = null;
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$row   = $statement->fetch();
			if($row !== false) {
				$location = new Location ($row["locationId"], $row["storageCode"], $row["description"]);
			}
		} catch(Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new PDOException($exception->getMessage(), 0, $exception));
		}
		return($locationId);
	}


	/**
	 * get Location by Storage Code
	 * @param PDO $pdo
	 * @param $location
	 * @return Location|null
	 */
	public static function getLocationByStorageCode(PDO &$pdo, $location) {
		// sanitize the storageCode before searching
		$location = filter_var($location, FILTER_VALIDATE_INT);
		if($location === false) {
			throw(new PDOException(""));
		}
		if($location <= 0) {
			throw(new PDOException("storage code is not positive"));
		}

		// create query template
		$query = "SELECT locationId, storageCode, description FROM location WHERE storageCode = :storageCode";
		$statement = $pdo->prepare($query);

		// bind the location id to the place holder in the template
		$parameters = array("storageCode" => $location);
		$statement->execute($parameters);

		// grab the location from mySQL
		try {
			$location = null;
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$row   = $statement->fetch();
			if($row !== false) {
				$location = new Location ($row["locationId"], $row["storageCode"], $row["description"]);
			}
		} catch(Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new PDOException($exception->getMessage(), 0, $exception));
		}
		return($location);
	}
}

