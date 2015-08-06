<?php

/**
 * Class User
 * The class to handle users
 * @author Charles Sandidge sandidgec@gmail.com
 */

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
	 * root user level
	 * @var string $root
	 */
	private $root;
	/**
	 * attention line
	 * @var string $attention ;
	 */
	private $attention;
	/**
	 * address line 1
	 * @var string $addressLineOne
	 */
	private $addressLineOne;
	/**
	 * address line 2
	 * @var string $addressLineTwo ;
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
	 * @var int $zipCode ;
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
	 * Constructor
	 * @param $newUserId
	 * @param $newLastName
	 * @param $newFirstName
	 * @param $newRoot
	 * @param $newAttention
	 * @param $newAddressLineOne
	 * @param $newAddressLineTwo
	 * @param $newCity
	 * @param $newState
	 * @param $newZipCode
	 * @param $newEmail
	 * @param $newPhoneNumber
	 * @param $newSalt
	 * @param $newHash
	 * @throws Exception
	 */
	public function __construct($newUserId, $newLastName, $newFirstName, $newRoot, $newAttention, $newAddressLineOne, $newAddressLineTwo,
								$newCity, $newState, $newZipCode, $newEmail, $newPhoneNumber, $newSalt, $newHash) {
		try {
			$this->setUserId($newUserId);
			$this->setLastName($newLastName);
			$this->setFirstName($newFirstName);
			$this->setRoot($newRoot);
			$this->setAttention($newAttention);
			$this->setAddressLineOne($newAddressLineOne);
			$this->setAddressLineTwo($newAddressLineTwo);
			$this->setCity($newCity);
			$this->setState($newState);
			$this->setZipCode($newZipCode);
			$this->setEmail($newEmail);
			$this->setPhoneNumber($newPhoneNumber);
			$this->setSalt($newSalt);
			$this->setHash($newHash);
		} catch(InvalidArgumentException $invalidArgument) {
			//rethrow the exception to the caller
			throw(new InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch
		(RangeException $range)  {
			// rethrow the exception to the caller
			throw (new RangeException($range->getMessage(),0, $range));
		} catch(Exception $exception) {
			// rethrow generic exception
			throw(new Exception($exception->getMessage(), 0, $exception));
		}
	}


	/**
	 * accessor method for userId
	 *
	 * @return int value of userId
**/

	public function getUserId() {
		return ($this->userId);
	}

	/**
	 * mutator for the userId
	 * @param $newUserId
	 */

	public function setUserId($newUserId) {
		// base case: if the userId is null,
		// this is a new user without a mySQL assigned id (yet)
		if($newUserId=== null) {
			$this->userId = null;
			return;
		}
		//verify the User is valid
		$newUserId = filter_var($newUserId, FILTER_VALIDATE_INT);
		if(empty($newUserId) === true) {
			throw (new InvalidArgumentException ("userId invalid"));
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
			throw new InvalidArgumentException("last name invalid");
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
			throw new InvalidArgumentException("first name invalid");
		}
		if(strlen($newFirstName) > 32) {
			throw new RangeException ("First Name content too large");
		}
		$this->firstName = $newFirstName;
	}

	/**
	 * accessor for Root
	 * @return string
	 */
	public function isRoot() {
		return ($this->root);
	}

	/**
	 * Mutator for Root
	 * @param $newRoot
	 */
	public function setRoot($newRoot) {
		//verify Root is no more than 1 char
		$newRoot = filter_var($newRoot, FILTER_SANITIZE_STRING);
		if(empty($newRoot) === true) {
			throw new InvalidArgumentException ("root invalid");
		}
		if(strlen($newRoot) > 1) {
			throw new RangeException ("Root too long");
		}
		$this->root = $newRoot;
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
			throw new InvalidArgumentException ("attention invalid");
		}
		if(strlen($newAttention) > 64) {
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
			throw new InvalidArgumentException ("address line one invalid");
		}
		if(strlen($newAddressLineOne) > 64) {
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
			throw new InvalidArgumentException ("address line two invalid");
		}
		if(strlen($newAddressLineTwo) > 64) {
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
	 * @param $newCity allows for no more than 64 string for city
	 */
	public function setCity($newCity) {
		//verify city is no more than 64 varchar
		$newCity = filter_var($newCity, FILTER_SANITIZE_STRING);
		if(empty($newCity) === true) {
			throw new InvalidArgumentException ("city invalid");
		}
		if(strlen($newCity) > 64) {
			throw new RangeException ("City too Long");
		}
		$this->city = $newCity;
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
	 * @param $newState allows only 2 characters ex."NM"
	 */
	public function setState($newState) {
		//verify State is no more than 2 char
		$newState = filter_var($newState, FILTER_SANITIZE_STRING);
		if(empty($newState) === true) {
			throw new InvalidArgumentException ("state invalid");
		}
		if(strlen($newState) !== 2) {
			throw new RangeException ("Invalid State Entry");
		}
		$this->state = $newState;
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
	 * @param $newZipCode allow no more than 10 character string ex. 85878-8587
	 */
	public function setZipCode($newZipCode) {
		//verify address is no more than 64 varchar
		$newZipCode = filter_var($newZipCode, FILTER_SANITIZE_STRING);
		if(empty($newZipCode) === true) {
			throw new InvalidArgumentException ("zipCode invalid");
		}
		if(strlen($newZipCode) > 10) {
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
	 * @param $newEmail  Sanitized email
	 */
	public function setEmail($newEmail) {
		// verify email is valid
		$newEmail = filter_var($newEmail, FILTER_SANITIZE_EMAIL);
		if(empty($newEmail) === true) {
			throw new InvalidArgumentException ("user email invalid");
		}
		if(strlen($newEmail) > 64) {
			throw new RangeException ("Email content too large");
		}
		$this->email = $newEmail;
	}

	/**
	 * Accessor for Phone Number
	 * @return int  returns phone number
	 */
	public function getPhoneNumber() {
		return ($this->phoneNumber);
	}

	/**
	 * Mutator for Phone Number
	 * @param $newPhoneNumber set phone number to exactly 10 digit(int)
	 */
	public function setPhoneNumber($newPhoneNumber) {
		//verify phone number is valid and digits only
		if((ctype_digit($newPhoneNumber)) === false) {
			throw new InvalidArgumentException ("phoneNumber invalid");
		}
		if(strlen($newPhoneNumber) > 10) {
			throw new RangeException ("Phone Number should be formatted 5055558787");
		}
		$this->phoneNumber = $newPhoneNumber;
	}

	/**
	 * accessor for Hash
	 * @return string of Hash
	 */
	public function getHash() {
		return ($this->hash);
	}

	/**
	 * Mutator for hash
	 * @param $newHash setting lenght of hash to exactly 128
	 */

	public function setHash($newHash) {
		// verify Hash is exactly string of 128
		if((ctype_xdigit($newHash)) === false) {
			if(empty($newHash) === true) {
				throw new InvalidArgumentException ("hash invalid");
			}
			if(strlen($newHash) !== 128) {
				throw new RangeException ("hash not valid");
			}
			$this->hash = $newHash;
		}
	}

	/**
	 * accessor for Salt
	 * @return string of Salt
	 */
	public
	function getSalt() {
		return ($this->salt);
	}


	/**
	 * mutator for Salt
	 * @param $newSalt setting string length to exactly 64
	 */
	public function setSalt($newSalt) {
		// verify salt is exactly string of 64
		if((ctype_xdigit($newSalt)) === false) {
			if(empty($newSalt) === true) {
				throw new InvalidArgumentException ("salt invalid");
			}
			if(strlen($newSalt) !== 64) {
				throw new RangeException ("salt not valid");
			}
			$this->salt = $newSalt;
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
//		var_dump($this);
		$query
			= "INSERT INTO user(lastName, firstName, attention, addressLineOne, addressLineTwo, city, state, zipCode,email, phoneNumber, salt, hash)
		VALUES (:lastName, :firstName, :attention, :addressLineOne, :addressLineTwo, :city, :state, :zipCode, :email, :phoneNumber, :salt, :hash)";
		$statement = $pdo->prepare($query);

		// bind the variables to the place holders in the template
		$parameters = array("lastName" => $this->lastName, "firstName" => $this->firstName, "attention" => $this->attention,
			"addressLineOne" => $this->addressLineOne, "addressLineTwo" => $this->addressLineTwo, "city" => $this->city,
			"state" => $this->state, "zipCode" => $this->zipCode, "email" => $this->email, "phoneNumber"=> $this->phoneNumber,
			"salt" => $this->salt, "hash" => $this->hash);
		$statement->execute($parameters);

		//update null userId with what mySQL just gave us
		$this->userId = intval($pdo->lastInsertId());
	}

	/**
	 * Deletes userId
	 * @param PDO $pdo
	 */
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

	/**
	 * @param PDO $pdo
	 */
	public function update(PDO &$pdo) {

		// create query template
		$query	 = "UPDATE user SET firstName = :firstName, lastName = :lastName, attention = :attention, addressLineOne = :addressLineOne,
 		addressLineTwo = :addressLineTwo, city = :city, state = :state, zipCode = :zipCode, email = :email, phoneNumber = :phoneNumber,
		hash = :hash, salt = :salt WHERE userId = :userId";
		$statement = $pdo->prepare($query);

		// bind the member variables
		$parameters = array("firstName" => $this->firstName, "lastName" => $this->lastName, "attention" => $this->attention,
			"addressLineOne" => $this->addressLineOne, "addressLineTwo" => $this->addressLineTwo, "city" => $this->city, "state" => $this->state,
			"zipCode" => $this->zipCode, "email" => $this->email, "phoneNumber" => $this->phoneNumber, "hash" => $this->hash,
			"salt" => $this->salt, "userId" => $this->userId);
		$statement->execute($parameters);
	}

	/**
	 * @param PDO $pdo
	 * @param $userId
	 * @return mixed|User
	 */
	public static function getUserByUserId(PDO &$pdo, $userId) {
		// sanitize the userId before searching
		$userId = filter_var($userId, FILTER_VALIDATE_INT);
		if($userId === false) {
			throw(new PDOException("user id is not an integer"));
		}
		if($userId <= 0) {
			throw(new PDOException("user id is not positive"));
		}

		// create query template
		$query = "SELECT userId, email, firstName, lastName, phoneNumber, attention, addressLineOne,
				addressLineTwo, city, state, zipCode, root, salt, hash FROM user WHERE userId = :userId";
		$statement = $pdo->prepare($query);

		// bind the user id to the place holder in the template
		$parameters = array("userId" => $userId);
		$statement->execute($parameters);

		// grab the user from mySQL
		try {
			$userId = null;
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$row   = $statement->fetch();
			if($row !== false) {
				$userId = new User ($row["userId"]);
			}
		} catch(Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new PDOException($exception->getMessage(), 0, $exception));
		}
		return($userId);
	}

	/**
	 * get user by email
	 * @param PDO $pdo
	 * @param $user
	 * @return null|User
	 */
	public static function getUserByEmail(PDO &$pdo, $user) {
		// sanitize the email before searching
		$user = filter_var($user, FILTER_SANITIZE_EMAIL);
		if($user === false) {
			throw(new PDOException(""));
		}
		if($user <= 0) {
			throw(new PDOException("email is not positive"));
		}

		// create query template
		$query = "SELECT userId, email, firstName, lastName, phoneNumber, attention, addressLineOne, addressLineTwo,
					city, state, zipCode, root, salt, hash FROM user WHERE email = :email";
		$statement = $pdo->prepare($query);

		// bind the user id to the place holder in the template
		$parameters = array("email" => $user);
		$statement->execute($parameters);

		// grab the user from mySQL
		try {
			$user = null;
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$row   = $statement->fetch();
			if($row !== false) {
				$user = new User ($row["userId"], $row["firstName"], $row["lastName"], $row["root"], $row["attention"],
								$row["addressLineOne"], $row["addressLineTwo"], $row["city"], $row["state"], $row["zipCode"],
								$row["email"], $row["salt"], $row["hash"]);
			}
		} catch(Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new PDOException($exception->getMessage(), 0, $exception));
		}
		return($user);
	}
}










