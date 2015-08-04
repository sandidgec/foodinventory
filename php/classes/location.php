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
			= "INSERT INTO location(storageCode, description)
		VALUES (:storageCode, :description)";
		$statement = $pdo->prepare($query);

		// bind the variables to the place holders in the template
		$parameters = array("storageCode" => $this->storageCode, "description" => $this->description);

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

	public function update(PDO &$pdo) {

		// create query template
		$query	 = "UPDATE location SET storageCode = :storageCode, description = :description WHERE locationId = :locationId";
		$statement = $pdo->prepare($query);

		// bind the member variables
		$parameters = array("storageCode" => $this->storageCode, "description" => $this->description, "locationId" => $this->locationId);
		$statement->execute($parameters);
	}
}

