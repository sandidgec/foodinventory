<?php

class User {

	/**
	 * id for this user; this is the primary key
	 * @var int $userId
	 **/
	private $userId;
	/**
	 * lastName of userId
	 * @var string $lastName
	 **/
	private $lastName;
	/**
	 * firstName of userId
	 * @var string $firstName
	 **/
	private $firstName;
	/**
	 * attention line
	 * @var string $attention;
	 */
	private $attention;
	/**
	 * address line 1
	 * @var string $addressLineOne
	 */
	private $addressLineOne;
	/**
	 * address line 2
	 * @var string $addressLineTwo;
	 */
	private $addressLineTwo;
	/**
	 * City
	 * @var string $city
	 */
	private $city;
	/**
	 * state
	 * @var string $state
	 */
	private $state;
	/**
	 * ZipCode
	 * @var int $zipCode;
	 */
	private $zipCode;
	/**
	 * email of userId
	 * @var string $email
	 **/
	private $email;
	/**
	 * phoneNumber of userId
	 * @var int $phoneNumber
	 **/
	private $phoneNumber;
	/**
	 * password hash for userId;
	 * @var string $passwordHash
	 **/
	private $hash;
	/**
	 * password salt for userId;
	 * @var string $passwordSalt
	 */
	private $salt;


	/**
	 * Constructor for user id
	 *
	 * @param $newUserId
	 * @param $newLastName
	 * @param $newFirstName
	 * @param $newAttention
	 * @param $newAddressLineOne
	 * @param $newAddressLineTwo
	 * @param $newCity
	 * @param $newState
	 * @param $newZipCode
	 * @param $newEmail
	 * @param $newSalt
	 * @param $newHash
	 */
	public
	function __construct($newUserId, $newLastName, $newFirstName,$newAttention,$newAddressLineOne,$newAddressLineTwo,
								$newCity,$newState,$newZipCode,$newEmail, $newSalt, $newHash) {
		try {
			$this->setUserId($newUserId);
			$this->setLastName($newLastName);
			$this->setFirstName($newFirstName);
			$this->setEmail($newEmail);
			$this->setSalt($newSalt);
			$this->setHash($newHash);
			$this->setAttention($newAttention);
			$this->setAddressLineOne($newAddressLineOne);
			$this->setAddressLineTwo($newAddressLineTwo);
			$this->setCity($newCity);
			$this->setState($newState);
			$this->setZipCode($newZipCode);
		} catch(InvalidArgumentException $invalidArgument) {
			//rethrow the exception to the caller
			throw(new InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		}
	}


	/**
	 * accessor method for profile id
	 *
	 * @return int value of profile id
	 **/

	public function getUserId() {
		return ($this->userId);
	}

	/**
	 * mutator for the userId
	 * @param $newUserId
	 */

	public function setUserId($newUserId) {
		//verify the User is valid
		$newUserId = filter_var($newUserId, FILTER_VALIDATE_INT);
		if(empty($newUserId) === true) {
			throw (new InvalidArgumentException ("content invalid"));
		}
		$this->userId = $newUserId;
	}

	/**
	 * accessor method for Last Name
	 *
	 */

	public function getLastName() {
		return ($this->lastName);
	}

	/**
	 * Mutator for last name sanitation
	 * @param $newLastName
	 */
	public function setLastName($newLastName) {
		//verify last name is valid
		$newLastName = filter_var($newLastName, FILTER_SANITIZE_STRING);
		if(empty($newLastName) === true) {
			throw new InvalidArgumentException("content invalid");
		}
		if(strlen($newLastName) > 32) {
			throw new RangeException("Last Name content too large");
		}
		$this->lastName = $newLastName;
	}

	/**
	 * accessor method for First Name
	 * @return string
	 */

	public function getFirstName() {
		return ($this->firstName);
	}

	/**
	 * Mutator method for First Name
	 * @param $newFirstName
	 */
	public function setFirstName($newFirstName) {
		// verify first name is valid
		$newFirstName = filter_var($newFirstName, FILTER_SANITIZE_STRING);
		if(empty($newFirstName) === true) {
			throw new InvalidArgumentException("content invalid");
		}
		if(strlen($newFirstName) > 32) {
			throw new RangeException ("First Name content too large");
		}
		$this->firstName = $newFirstName;
	}
	/**
	 * accessor for attention
	 * @return string
	 */
	public function getAttention() {
		return ($this->attention);
	}

	/**
	 * Mutator for Attention
	 * @param $newAttention
	 */
	public function setAttention($newAttention) {
		//verify attention is no more than 64 varchar
		$newAttention = filter_var($newAttention, FILTER_SANITIZE_STRING);
		if(empty($newAttention) === true) {
			throw new InvalidArgumentException ("content invalid");
		}
		if(strlen($newAttention)>64) {
			throw new RangeException ("Address Line One too Long");
		}
		$this->attention = $newAttention;
	}

	/**
	 * accessor for address line one
	 * @return string
	 */
	public function getAddressLineOne() {
		return ($this->addressLineOne);
	}

	/**
	 * Mutator for Address Line One
	 * @param $newAddressLineOne
	 */
	public function setAddressLineOne($newAddressLineOne) {
		//verify address is no more than 64 varchar
		$newAddressLineOne = filter_var($newAddressLineOne, FILTER_SANITIZE_STRING);
		if(empty($newAddressLineOne) === true) {
			throw new InvalidArgumentException ("content invalid");
		}
		if(strlen($newAddressLineOne)>64) {
			throw new RangeException ("Address Line One too Long");
		}
		$this->addressLineOne = $newAddressLineOne;
	}

	/**
	 * accessor for address line two
	 * @return string
	 */
	public function getAddressLineTwo() {
		return ($this->addressLineTwo);
	}

	/**
	 * Mutator for Address Line Two
	 * @param $newAddressLineTwo
	 */
	public function setAddressLineTwo($newAddressLineTwo) {
		//verify address is no more than 64 varchar
		$newAddressLineTwo = filter_var($newAddressLineTwo, FILTER_SANITIZE_STRING);
		if(empty($newAddressLineTwo) === true) {
			throw new InvalidArgumentException ("content invalid");
		}
		if(strlen($newAddressLineTwo)>64) {
			throw new RangeException ("Address Line Two too Long");
		}
		$this->addressLineTwo = $newAddressLineTwo;
	}
	/**
	 * accessor for City
	 * @return string
	 */
	public function getCity() {
		return ($this->city);
	}

	/**
	 * Mutator for City
	 * @param $newCity
	 */
	public function setCity($newCity) {
		//verify city is no more than 64 varchar
		$newCity = filter_var($newCity, FILTER_SANITIZE_STRING);
		if(empty($newCity) === true) {
			throw new InvalidArgumentException ("content invalid");
		}
		if(strlen($newCity)>64) {
			throw new RangeException ("City too Long");
		}
		$this->attention = $newCity;
	}
	/**
	 * accessor for State
	 * @return string
	 */
	public function getState() {
		return ($this->state);
	}
	/**
	 * Mutator for State
	 * @param $newState
	 */
	public function setState($newState) {
		//verify State is no more than 2 char
		$newState = filter_var($newState, FILTER_SANITIZE_STRING);
		if(empty($newState) === true) {
			throw new InvalidArgumentException ("content invalid");
		}
		if(strlen($newState)!==2) {
			throw new RangeException ("Invalid State Entry");
		}
		$this->attention = $newState;
	}
	/**
	 * accessor for zipCode
	 * @return int
	 */
	public function getZipCode() {
		return ($this->zipCode);
	}

	/**
	 * Mutator for zipCode
	 * @param $newZipCode
	 */
	public function setZipCode($newZipCode) {
		//verify address is no more than 64 varchar
		$newZipCode = filter_var($newZipCode, FILTER_SANITIZE_STRING);
		if(empty($newZipCode) === true) {
			throw new InvalidArgumentException ("content invalid");
		}
		if(strlen($newZipCode)>10) {
			throw new RangeException ("ZipCode too Long");
		}
		$this->zipCode = $newZipCode;
	}

	/**
	 * accessor for email
	 * @return string
	 */
	public function getEmail() {
		return ($this->email);
	}

	/**
	 * Mutator for Email
	 * @param $newEmail
	 */
	public function setEmail($newEmail) {
		// verify email is valid
		$newEmail = filter_var($newEmail, FILTER_SANITIZE_EMAIL);
		if(empty($newEmail) === true) {
			throw new InvalidArgumentException ("content invalid");
		}
		if(strlen($newEmail) > 64) {
			throw new RangeException ("Email content too large");
		}
		$this->email = $newEmail;
	}

	/**
	 * Accessor for Phone Number
	 * @return int
	 */
	public function getPhoneNumber() {
		return ($this->phoneNumber);
	}

	/**
	 * Mutator for Phone Number
	 * @param $newPhoneNumber
	 */
	public function setPhoneNumber($newPhoneNumber) {
		//verify phone number is valid and digits only
		if((ctype_digit($newPhoneNumber)) === false) {
			throw new InvalidArgumentException ("content invalid");
		}
		if(strlen($newPhoneNumber) > 10) {
			throw new RangeException ("Phone Number should be formatted 5055558787");
		}
		$this->phoneNumber = $newPhoneNumber;
	}

	/**
	 * accessor for Hash
	 * @return string
	 */
	public function getHash() {
		return ($this->hash);
	}

	/**
	 * Mutator for hash
	 * @param $newHash
	 */

	public function setHash($newHash) {
		// verify Hash is exactly string of 128
		if((ctype_digit($newHash)) === false) {
			if(empty($newHash) === true) {
				throw new InvalidArgumentException ("content invalid");
			}
			if(strlen($newHash) !== 128) {
				throw new RangeException ("hash not valid");
			}
			$this->hash = $newHash;
		}
	}

	/**
	 * accessor for Salt
	 * @return string
	 */
	public
	function getSalt() {
		return ($this->salt);
	}


	/**
	 * mutator for Salt
	 * @param $newSalt
	 */
	public function setSalt($newSalt) {
		// verify Hash is exactly string of 128
		if((ctype_digit($newSalt)) === false) {
			if(empty($newSalt) === true) {
				throw new InvalidArgumentException ("content invalid");
			}
			if(strlen($newSalt) !== 64) {
				throw new RangeException ("hash not valid");
			}
			$this->hash = $newSalt;
		}
	}

	/**
	 * Inserts this userId into mySQL
	 * @param PDO $pdo
	 */
	public function insert(PDO &$pdo) {
		// make sure user doesn't already exist
		if($this->userId !== null) {
			throw (new PDOException("existing user"));
		}
		//create query template
		$query
	= "INSERT INTO user(lastName, firstName, attention, addressLineOne, addressLineTwo, city, state, zipCode,email, salt, hash)
		VALUES (:lastName, :firstName, :attention, :addressLineOne, :addressLineTwo, :city, :state, :zipCode, :email, :salt, :hash)";
			$statement = $pdo->prepare($query);

		// bind the variables to the place holders in the template
		$parameters = array("lastName" => $this->lastName, "firstName" => $this->firstName, "attention" => $this->attention,
			"addressLineOne" => $this->addressLineOne, "addressLineTwo" => $this->addressLineTwo, "city" => $this->city,
			"state" => $this->state, "zipCode" => $this->zipCode, "email" => $this->email, "salt" => $this->salt,"hash" => $this->hash);
		$statement->execute($parameters);

		//update null userId with what mySQL just gave us
		$this->userId = intval($pdo->lastInsertId());
	}
	public function delete(PDO &$pdo) {
		// enforce the user is not null
		if($this->userId === null) {
			throw(new PDOException("unable to delete a user that does not exist"));
		}

		//create query template
		$query = "DELETE FROM user WHERE userId = :userId";
		$statement = $pdo->prepare($query);

		//bind the member variables to the place holder in the template
		$parameters = array("userId" => $this->userId);
		$statement->execute($parameters);
	}
}







