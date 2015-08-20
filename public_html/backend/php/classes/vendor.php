<?php
/**
 * this is the vendor class for the inventoryText capstone project
 *
 * this vendor class will track which inventory items come from which vendors and where to reorder each item. it will also
 * contain contact information and lead time, which will be the average time between placing an order and receiving order items
 *
 * @author James Huber <jhuber8@cnm.edu>
 **/
class Vendor implements JsonSerializable {
	/**
	 * id for each vendor, this is the primary key
	 * @var int $vendorId
	 **/
	private $vendorId;
	/**
	 * name of contact/salesperson at vendor company
	 * @var string $contactName
	 */
	private $contactName;
	/**
	 * email for placing orders or contacting vendor
	 * @var string $vendorEmail
	 **/
	private $vendorEmail;
	/**
	 * this is the company name of vendor
	 * @var string $vendorName
	 **/
	private $vendorName;
	/**
	 *this is the phone number for contact at vendor company
	 * @var int $vendorPhoneNumber
	 **/
	private $vendorPhoneNumber;
	/**
	 * constructor for this Vendor
	 *
	 * @param int $newVendorId id of this vendor or null if unknown vendor
	 * @param int $newContactName name of contact/salesperson for vendor
	 * @param string $newVendorEmail string email address for vendor
	 * @param string $newVendorName string names of vendor
	 * @param int $newVendorPhoneNumber int phone number of vendor
	 * @throws InvalidArgumentException if data types are not valid
	 * @throws RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws Exception if some other exception is thrown
	 **/
	public function __construct($newVendorId, $newContactName, $newVendorEmail, $newVendorName, $newVendorPhoneNumber) {
		try {
			$this->setVendorId($newVendorId);
			$this->setContactName($newContactName);
			$this->setVendorEmail($newVendorEmail);
			$this->setVendorName($newVendorName);
			$this->setVendorPhoneNumber($newVendorPhoneNumber);
		} catch(InvalidArgumentException $invalidArgument) {
			// rethrow the exception to the caller
			throw(new InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(RangeException $range) {
			// rethrow the exception to the caller
			throw(new RangeException($range->getMessage(), 0, $range));
		} catch(Exception $exception) {
			//rethrow generic mysqli_sql_exception
			throw(new Exception($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for $vendorId
	 * @return mixed value of vendor id
	 **/
	public function getVendorId(){
		return($this->vendorId);
	}
	/**
	 * mutator method for vendor id
	 *
	 * @param int 4newVendorId new value of vendor id
	 * @throws InvalidArgumentException if $newVendorId is not an integer
	 * @throws RangeException if $newVendorId is not positive
	 **/
	public function setVendorId($newVendorId){
		//base case: if the vendor id is null, this is a new vendor without a mySQL assigned id (yet)
		if($newVendorId === null) {
			$this->vendorId = null;
			return;
		}

		// verify the notification id is valid
		$newVendorId = filter_var($newVendorId, FILTER_VALIDATE_INT);
		if($newVendorId === false) {
			throw(new InvalidArgumentException("vendor id is not a valid integer"));
		}
		// verify the actor id is positive
		if($newVendorId <= 0) {
			throw(new RangeException("vendor id is not positive"));
		}
		// convert and store the vendor id
		$this->vendorId = intval($newVendorId);
	}
	/**
	 * accessor method for contact name
	 * @return mixed value of contact name
	 **/
	public function getContactName(){
		return($this->contactName);
	}
	/**
	 * mutator method for contact name
	 *
	 * @param string $newContactName new value of contact name
	 * @throws InvalidArgumentException if $newContactName is not a string or insecure
	 * @throws RangeException if $newContactName is > 64 characters
	 **/
	public function setContactName($newContactName){
		//verify the contact name is secure
		$newContactName = trim($newContactName);
		$newContactName = filter_var($newContactName, FILTER_SANITIZE_STRING);
		if(empty($newContactName)=== true){
			throw(new InvalidArgumentException("contact name is empty or insecure"));
		}
		//verify the contact name will fit into database
		if(strlen($newContactName)>64){
			throw(new RangeException("contact name is too large"));
		}
		//store the contact name
		$this->contactName = $newContactName;
	}
	/**
	 * accessor method for vendor email
	 * @return mixed value for vendor email
	 **/
	public function getVendorEmail(){
		return($this->vendorEmail);
	}
	/**
	 * Mutator for vendor email
	 * @param string $newVendorEmail new value for vendor email
	 * @throw InvalidArgumentException if $newVendorEmail is not a string or insecure
	 * @throw RangeException if $newVendorEmail > 64 characters
	 **/
	public function setVendorEmail($newVendorEmail) {
		// verify vendor email is secure
		$newVendorEmail = filter_var($newVendorEmail, FILTER_SANITIZE_EMAIL);
		if(empty($newVendorEmail) === true) {
			throw new InvalidArgumentException ("vendor email is invalid");
		}
		if(strlen($newVendorEmail) > 64) {
			throw new RangeException ("vendor address is too large");
		}
		//store the vendor email
		$this->vendorEmail = $newVendorEmail;
	}
	/**
	 * accessor method for vendor name
	 * @return mixed value for vendor name
	 **/
	public function getVendorName(){
		return($this->vendorName);
	}
	/**
	 * mutator method for vendor name
	 * @param string $newVendorName new value of vendor name
	 * @throw InvalidArgumentException if $newVendorName is not a string or insecure
	 * @throw RangeExcpetion if $newVendorName >64 characters
	**/
	public Function setVendorName($newVendorName){
		//verify the vendor name is secure
		$newVendorName = trim($newVendorName);
		$newVendorName = filter_var($newVendorName, FILTER_SANITIZE_STRING);
		if(empty($newVendorName)===true){
			throw(new InvalidArgumentException("vendor name is empty or insecure"));
		}
		//verify the vendor name will fit into database
		if(strlen($newVendorName)>64){
			throw(new RangeException("vendor name is too large"));
		}
		//store vendor name
		$this->vendorName = $newVendorName;
	}
	/**
	* accessor method for vendor phone number
	 * @return int value for vendor phone number
	 **/
	public function getVendorPhoneNumber(){
		return($this->vendorPhoneNumber);
	}
	/**
	 * mutator method for vendor phone number
	 * @param int $newVendorPhoneNumber new value of vendor phone number
	 * @throw InvalidArgumentException if $newVendorPhoneNumber is not an interger
	 * @throw RangeException if $newVendorPhoneNumber is not positive
	 **/
	public function setVendorPhoneNumber($newVendorPhoneNumber){
		//verify vendor phone number is valid and digits only
		if((ctype_digit($newVendorPhoneNumber)) === false){
			throw(new InvalidArgumentException("vendor phone number is invalid"));
		}
		if(strlen($newVendorPhoneNumber)>10){
			throw(new RangeException("vendor phone number is formatted 5555555555"));
		}
		$this->vendorPhoneNumber = $newVendorPhoneNumber;
	}
	/**
	 * determines which variables to include in json_encode()
	 *
	 * @see http://php.net/manual/en/class.jsonserializable.php JsonSerializable interface
	 * @return array all object variables, including private variables
	 **/
	public function JsonSerialize() {
		$fields = get_object_vars($this);
		return ($fields);
	}
	/**
	 * * inserts this Vendor into mySQL
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @throws PDOException when mySQL related errors occur
	 **/
	public function insert(PDO &$pdo) {
		// enforce the vendorId is null (i.e., don't insert a vendor that already exists)
		if($this->vendorId !== null) {
			throw(new PDOException("not a new vendor"));
		}

		// create query template
		$query = "INSERT INTO vendor(contactName, vendorEmail, vendorName, vendorPhoneNumber)VALUES(:contactName, :vendorEmail, :vendorName, :vendorPhoneNumber)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = array("contactName" => $this->contactName, "vendorEmail" => $this->vendorEmail,
			 "vendorName" => $this->vendorName, "vendorPhoneNumber" => $this->vendorPhoneNumber);
		$statement->execute($parameters);

		// update the null vendorId with what mySQL just gave us
		$this->vendorId = intval($pdo->lastInsertId());
	}
	/**
	 * deletes this vendor from mySQL
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @throws PDOException when mySQL related errors occur
	 **/
	public function delete(PDO &$pdo) {
		// enforce the vendorId is not null (i.e., don't delete a vendor that hasn't been inserted)
		if($this->vendorId === null) {
			throw(new PDOException("unable to delete a vendor that does not exist"));
		}

		// create query template
		$query	 = "DELETE FROM vendor WHERE vendorId = :vendorId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holder in the template
		$parameters = array("vendorId" => $this->vendorId);
		$statement->execute($parameters);
	}
	/**
	 * updates this vendor in mySQL
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @throws PDOException when mySQL related errors occur
	 **/
	public function update(PDO &$pdo) {
		// enforce the vendorId is not null (i.e., don't update a vendor that hasn't been inserted)
		if($this->vendorId === null) {
			throw(new PDOException("unable to update a vendor that does not exist"));
		}

		// create query template
		$query	 = "UPDATE vendor SET contactName = :contactName, vendorEmail = :vendorEmail, vendorName = :vendorName, vendorPhoneNumber = :vendorPhoneNumber WHERE vendorId = :vendorId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = array("contactName" => $this->contactName, "vendorEmail" => $this->vendorEmail,"vendorName" => $this-> vendorName, "vendorPhoneNumber" => $this-> vendorPhoneNumber, "vendorId" => $this->vendorId);
		$statement->execute($parameters);
	}
	/**
	 * gets the vendor by vendorId
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @param int $vendorId vendor id to search for
	 * @return mixed vendor found or null if not found
	 * @throws PDOException when mySQL related errors occur
	 **/
	public static function getVendorByVendorId(PDO &$pdo, $vendorId) {
		// sanitize the vendorId before searching
		$vendorId = filter_var($vendorId, FILTER_VALIDATE_INT);
		if($vendorId === false) {
			throw(new PDOException("vendor id is not an integer"));
		}
		if($vendorId <= 0) {
			throw(new PDOException("vendor id is not positive"));
		}

		// create query template
		$query	 = "SELECT vendorId, contactName, vendorEmail, vendorName, vendorPhoneNumber FROM vendor WHERE vendorId = :vendorId";
		$statement = $pdo->prepare($query);

		// bind the vendor id to the place holder in the template
		$parameters = array("vendorId" => $vendorId);
		$statement->execute($parameters);

		// grab the vendor from mySQL
		try {
			$vendor = null;
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$row   = $statement->fetch();
			if($row !== false) {
				$vendor = new Vendor($row["vendorId"], $row["contactName"], $row["vendorEmail"], $row["vendorName"], $row["vendorPhoneNumber"]);
			}
		} catch(Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new PDOException($exception->getMessage(), 0, $exception));
		}
		return($vendor);
	}
	/**
	 * gets the vendor by vendorEmail
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @param string $vendorEmail vendor email to search for
	 * @return mixed Tweet found or null if not found
	 * @throws PDOException when mySQL related errors occur
	 **/
	public static function getVendorByVendorEmail(PDO &$pdo, $vendorEmail) {
		// sanitize the description before searching
		$vendorEmail = trim($vendorEmail);
		$vendorEmail = filter_var($vendorEmail, FILTER_SANITIZE_EMAIL);
		if(empty($vendorEmail) === true) {
			throw(new PDOException("vendor email is invalid"));
		}

		// create query template
		$query = "SELECT vendorId, contactName, vendorEmail, vendorName, vendorPhoneNumber FROM vendor WHERE vendorEmail = :vendorEmail";
		$statement = $pdo->prepare($query);

		// bind the vendor email to the place holder in the template
		$parameters = array("vendorEmail" => $vendorEmail);
		$statement->execute($parameters);

		// grab the vendor from mySQL
		try {
			$vendor = null;
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$row   = $statement->fetch();
			if($row !== false) {
				$vendor = new Vendor($row["vendorId"], $row["contactName"], $row["vendorEmail"], $row["vendorName"], $row["vendorPhoneNumber"]);
			}
		} catch(Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new PDOException($exception->getMessage(), 0, $exception));
		}
		return($vendor);
	}
	/**
	 * gets the vendor by vendorName
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @param string $vendorName vendor name to search for
	 * @return mixed Tweet found or null if not found
	 * @throws PDOException when mySQL related errors occur
	 **/
	public static function getVendorByVendorName(PDO &$pdo, $vendorName) {
		// sanitize the description before searching
		$vendorName = trim($vendorName);
		$vendorName = filter_var($vendorName, FILTER_SANITIZE_STRING);
		if(empty($vendorName) === true) {
			throw(new PDOException("vendor name is invalid"));
		}

		// create query template
		$query = "SELECT vendorId, contactName, vendorEmail, vendorName, vendorPhoneNumber FROM vendor WHERE vendorName LIKE :vendorName";
		$statement = $pdo->prepare($query);

		// bind the vendor name to the place holder in the template
		$vendorName = "%$vendorName%";
		$parameters = array("vendorName" => $vendorName);
		$statement->execute($parameters);

		//build an array of vendors
		$vendors = new SplFixedArray($statement->rowCount());
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$vendor = new Vendor($row["vendorId"], $row["contactName"], $row["vendorEmail"], $row["vendorName"], $row["vendorPhoneNumber"]);
				$vendors[$vendors->key()] = $vendor;
				$vendors->next();
			} catch(Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($vendors);
	}
	/**
	 * gets all Vendors
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @return SplFixedArray all vendors found
	 * @throws PDOException when mySQL related errors occur
	 **/
	public static function getAllVendors(PDO &$pdo) {
		// create query template
		$query = "SELECT vendorId, contactName, vendorEmail, vendorName, vendorPhoneNumber FROM vendor";
		$statement = $pdo->prepare($query);

		//build an array of vendors
		$vendors = new SplFixedArray($statement->rowCount());
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !==false){
			try {
				$vendor = new Vendor($row["vendorId"], $row["contactName"], $row["vendorEmail"], $row["vendorName"], $row["vendorPhoneNumber"]);
				$vendors[$vendors->key()] = $vendor;
				$vendors->next();
			} catch(PDOException $exception) {
				//if the row couldn't be converted, rethrow it
				throw(new PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($vendors);
	}
}