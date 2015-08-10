<?php

/**
 * Class User for sites base of users
 *
 * The class to handle users
 *
 * @author Charles Sandidge sandidgec@gmail.com
 **/

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
	 * @var bool $root
	 **/
	private $root;
	/**
	 * attention line
	 * @var string $attention ;
	 **/
	private $attention;
	/**
	 * address line 1
	 * @var string $addressLineOne
	 */
	private $addressLineOne;
	/**
	 * address line 2
	 * @var string $addressLineTwo ;
	 **/
	private $addressLineTwo;
	/**
	 * City
	 * @var string $city
	 */
	private $city;
	/**
	 * state
	 * @var string $state
	 **/
	private $state;
	/**
	 * ZipCode
	 * @var string $zipCode
	 **/
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
	 **/
	private $salt;


	/**
	 * Constructor for User class
	 *
	 * @param int of unique user id for new user $newUserId
	 * @param string of last name for new user $newLastName
	 * @param string of first name for new user $newFirstName
	 * @param bool user is a root user or not (t or f) $newRoot
	 * @param string of attention line of address $newAttention
	 * @param string of address line one $newAddressLineOne
	 * @param string of address line two $newAddressLineTwo
	 * @param string of city info $newCity
	 * @param string 2 characters for state $newState
	 * @param string of zipcode $newZipCode
	 * @param string of users' email $newEmail
	 * @param int of users' phone number $newPhoneNumber
	 * @param string hex value of half of password $newSalt
	 * @param string hex value of half of password $newHash
	 * @throws Exception
	 **/
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
		} catch(RangeException $range)  {
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
	 * @return int value of unique userId
	**/
	public function getUserId() {
		return ($this->userId);
	}

	/**
	 * mutator method for the userId
	 *
	 * @param int unique value to represent a user $newUserId
	 * @throws InvalidArgumentException for invalid content
	 **/
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
	 * @return string for last name
	 **/
	public function getLastName() {
		return ($this->lastName);
	}

	/**
	 * Mutator method for last name sanitation
	 *
	 * @param string for user last name $newLastName
	 **/
	public function setLastName($newLastName) {
		//verify last name is valid
		$newLastName = filter_var($newLastName, FILTER_SANITIZE_STRING);
		if(empty($newLastName) === true) {
			throw new InvalidArgumentException("last name invalid");
		}
		if(strlen($newLastName) > 32) {
			throw (new RangeException("Last Name content too large"));
		}
		$this->lastName = $newLastName;
	}

	/**
	 * accessor method for First Name
	 *
	 * @return string for first name
	 **/
	public function getFirstName() {
		return ($this->firstName);
	}

	/**
	 * Mutator method for First Name
	 *
	 * @param string for user first name $newFirstName
	 */
	public function setFirstName($newFirstName) {
		// verify first name is valid
		$newFirstName = filter_var($newFirstName, FILTER_SANITIZE_STRING);
		if(empty($newFirstName) === true) {
			throw new InvalidArgumentException("first name invalid");
		}
		if(strlen($newFirstName) > 32) {
			throw (new RangeException ("First Name content too large"));
		}
		$this->firstName = $newFirstName;
	}

	/**
	 * accessor method for Root
	 *
	 * @return bool for root, true or false
	 **/
	public function isRoot() {
		return ($this->root);
	}

	/**
	 * Mutator method for Root to insure boolean success
	 *
	 * @param bool true or false for user being root or not $newRoot
	 * @throws InvalidArgumentException if root boolean fails
	 **/
	public function setRoot($newRoot) {
		//verify Root is no more than 1 char
		$newRoot = filter_var($newRoot, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
		if ($newRoot === null) {
			throw (new InvalidArgumentException ("root invalid"));
		}
		$this->root = $newRoot;
	}

	/**
	 * accessor method for attention
	 *
	 * @return string for attention line
	 **/
	public function getAttention() {
		return ($this->attention);
	}

	/**
	 * Mutator method for Attention
	 *
	 * @param string for attention $newAttention
	 * @throws InvalidArgumentException for invalid content
	 * @throws RangeException if longer than 64 characters
	 **/
	public function setAttention($newAttention) {
		//verify attention is no more than 64 varchar
		$newAttention =trim($newAttention);
		$newAttention = filter_var($newAttention, FILTER_SANITIZE_STRING);
		if(empty($newAttention) === true) {
			throw new InvalidArgumentException ("attention invalid");
		}
		if(strlen($newAttention) > 64) {
			throw (new RangeException ("Address Line One too Long"));
		}
		$this->attention = $newAttention;
	}

	/**
	 * accessor method for address line one
	 *
	 * @return string for address line one
	 **/
	public function getAddressLineOne() {
		return ($this->addressLineOne);
	}

	/**
	 * Mutator method for Address Line One
	 *
	 * @param string of user address line one $newAddressLineOne
	 * @throws InvalidArgumentException for invalid content
	 * @throws RangeException if longer than 64 characters
	 **/
	public function setAddressLineOne($newAddressLineOne) {
		//verify address is no more than 64 varchar
		$newAddressLineOne = filter_var($newAddressLineOne, FILTER_SANITIZE_STRING);
		if(empty($newAddressLineOne) === true) {
			throw new InvalidArgumentException ("address line one invalid");
		}
		if(strlen($newAddressLineOne) > 64) {
			throw (new RangeException ("Address Line One too Long"));
		}
		$this->addressLineOne = $newAddressLineOne;
	}

	/**
	 * accessor method for address line two
	 *
	 * @return string for address line two
	 **/
	public function getAddressLineTwo() {
		return ($this->addressLineTwo);
	}

	/**
	 * Mutator method for Address Line Two
	 *
	 * @param string of user address line two $newAddressLineTwo
	 * @throws InvalidArgumentException for invalid content
	 * @throws RangeException if longer than 64 characters
	 **/
	public function setAddressLineTwo($newAddressLineTwo) {
		//verify address is no more than 64 varchar
		$newAddressLineTwo = filter_var($newAddressLineTwo, FILTER_SANITIZE_STRING);
		if(empty($newAddressLineTwo) === true) {
			throw new InvalidArgumentException ("address line two invalid");
		}
		if(strlen($newAddressLineTwo) > 64) {
			throw (new RangeException ("Address Line Two too Long"));
		}
		$this->addressLineTwo = $newAddressLineTwo;
	}

	/**
	 * accessor method for City
	 *
	 * @return string for users' city
	 **/
	public function getCity() {
		return ($this->city);
	}

	/**
	 * Mutator method for City
	 *
	 * @param string of users' city $newCity
	 * @throws InvalidArgumentException if content is invalid
	 * @throws RangeException if city is longer than 64 characters
	 **/
	public function setCity($newCity) {
		//verify city is no more than 64 varchar
		$newCity = filter_var($newCity, FILTER_SANITIZE_STRING);
		if(empty($newCity) === true) {
			throw new InvalidArgumentException ("city invalid");
		}
		if(strlen($newCity) > 64) {
			throw (new RangeException ("City too Long"));
		}
		$this->city = $newCity;
	}

	/**
	 * accessor method for State
	 *
	 * @return string for users' state
	 **/
	public function getState() {
		return ($this->state);
	}

	/**
	 * Mutator method for State
	 *
	 * @param string for users' state $newState
	 * @throws InvalidArgumentException if string is invalid
	 * @throws RangeException if string is longer than 2 characters
	 **/
	public function setState($newState) {
		//verify State is no more than 2 char
		$newState = filter_var($newState, FILTER_SANITIZE_STRING);
		if(empty($newState) === true) {
			throw new InvalidArgumentException ("state invalid");
		}
		if(strlen($newState) !== 2) {
			throw (new RangeException ("Invalid State Entry"));
		}
		$this->state = $newState;
	}

	/**
	 * accessor method for zipCode
	 *
	 * @return string for zipcode
	 **/
	public function getZipCode() {
		return ($this->zipCode);
	}

	/**
	 * Mutator method for zipCode
	 *
	 * @param string for users' zipcode $newZipCode
	 * @throws InvalidArgumentException for invalid content
	 * @throws RangeException if zipCode is larger than 10 characters
	 **/
	public function setZipCode($newZipCode) {
		//verify address is no more than 64 varchar
		$newZipCode = filter_var($newZipCode, FILTER_SANITIZE_STRING);
		if(empty($newZipCode) === true) {
			throw new InvalidArgumentException ("zipCode invalid");
		}
		if(strlen($newZipCode) > 10) {
			throw (new RangeException ("ZipCode too Long"));
		}
		$this->zipCode = $newZipCode;
	}

	/**
	 * accessor method for email
	 *
	 * @return string of email for user
	 **/
	public function getEmail() {
		return ($this->email);
	}

	/**
	 * Mutator method for Email
	 *
	 * @param string of users' email $newEmail
	 * @throws InvalidArgumentException if email does not pass sanitization
	 * @throws RangeException if email is longer than 64 characters
	 **/
	public function setEmail($newEmail) {
		// verify email is valid
		$newEmail = filter_var($newEmail, FILTER_SANITIZE_EMAIL);
		if(empty($newEmail) === true) {
			throw new InvalidArgumentException ("user email invalid");
		}
		if(strlen($newEmail) > 64) {
			throw(new RangeException ("Email content too large"));
		}
		$this->email = $newEmail;
	}

	/**
	 * Accessor method for Phone Number
	 *
	 * @return int for phone number
	 **/
	public function getPhoneNumber() {
		return ($this->phoneNumber);
	}

	/**
	 * Mutator method for Phone Number
	 *
	 * @param int of user phone number $newPhoneNumber
	 * @throws InvalidArgumentException if phoneNumber is not ctype digits
	 * @throws RangeException if int is not 10 digits
	 **/
	public function setPhoneNumber($newPhoneNumber) {
		//verify phone number is valid and digits only
		if((ctype_digit($newPhoneNumber)) === false) {
			throw new InvalidArgumentException ("phoneNumber invalid");
		}
		if(strlen($newPhoneNumber) > 10) {
			throw (new RangeException ("Phone Number should be formatted 5055558787"));
		}
		$this->phoneNumber = $newPhoneNumber;
	}

	/**
	 * accessor method for Salt
	 *
	 * @return string of Salt for user password
	 **/
	public
	function getSalt() {
		return ($this->salt);
	}

	/**
	 * mutator method for Salt
	 *
	 * @param string of users password salt $newSalt
	 * @throw InvalidArgumentException if salt is not valid int
	 * @throw RangeException if salt is not exactly 64 xdigits
	 **/
	public function setSalt($newSalt) {
		// verify salt is exactly string of 64
		if((ctype_xdigit($newSalt)) === false) {
			if(empty($newSalt) === true) {
				throw new InvalidArgumentException ("salt invalid");
			}
			if(strlen($newSalt) !== 64) {
				throw (new RangeException ("salt not valid"));
			}
		}
		$this->salt = $newSalt;
	}


	/**
	 * accessor method for Hash
	 * @return string of users password Hash
	 **/
	public function getHash() {
		return ($this->hash);
	}

	/**
	 * Mutator for Hash -insure it is 128 length string
	 *
	 * @param string of users $newHash
	 * @throws InvalidArgumentException if newHash is not valid int
	 * @throws RangeException if newHash is not exactly 128 xdigits
	 **/

	public function setHash($newHash) {
		// verify Hash is exactly string of 128
		if((ctype_xdigit($newHash)) === false) {
			if(empty($newHash) === true) {
				throw new InvalidArgumentException ("hash invalid");
			}
			if(strlen($newHash) !== 128) {
				throw new RangeException ("hash not valid");
			}
		}
		$this->hash = $newHash;
	}

	/**
	 * Inserts User into mySQL
	 *
	 * Inserts this userId into mySQL in intervals
	 * @param PDO $pdo connection to
	 **/
	public function insert(PDO &$pdo) {
		// make sure user doesn't already exist
		if($this->userId !== null) {
			throw (new PDOException("existing user"));
		}
		//create query template
		$query
			= "INSERT INTO user(lastName, firstName, root, attention, addressLineOne, addressLineTwo, city, state, zipCode, email, phoneNumber, salt, hash)
		VALUES (:lastName, :firstName, :root, :attention, :addressLineOne, :addressLineTwo, :city, :state, :zipCode, :email, :phoneNumber, :salt, :hash)";
		$statement = $pdo->prepare($query);

		// bind the variables to the place holders in the template
		$parameters = array("lastName" => $this->lastName, "firstName" => $this->firstName, "root" => $this->root,
			"attention" => $this->attention,
			"addressLineOne" => $this->addressLineOne, "addressLineTwo" => $this->addressLineTwo, "city" => $this->city,
			"state" => $this->state, "zipCode" => $this->zipCode, "email" => $this->email, "phoneNumber"=> $this->phoneNumber,
			"salt" => $this->salt, "hash" => $this->hash);
		$statement->execute($parameters);

		//update null userId with what mySQL just gave us
		$this->userId = intval($pdo->lastInsertId());
	}

	/**
	 * Deletes User from mySQL
	 *
	 * Delete PDO to delete userId
	 * @param PDO $pdo
	 **/
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
	 * updates User in mySQL
	 *
	 * Update PDO to update user class
	 * @param PDO $pdo pointer to PDO connection, by reference
	 **/
	public function update(PDO &$pdo) {

		// create query template
		$query	 = "UPDATE user SET firstName = :firstName, lastName = :lastName, root = :root, attention = :attention, addressLineOne = :addressLineOne,
 		addressLineTwo = :addressLineTwo, city = :city, state = :state, zipCode = :zipCode, email = :email, phoneNumber = :phoneNumber,
		hash = :hash, salt = :salt WHERE userId = :userId";
		$statement = $pdo->prepare($query);

		// bind the member variables
		$parameters = array("firstName" => $this->firstName, "lastName" => $this->lastName,"root" => $this->root, "attention" => $this->attention,
			"addressLineOne" => $this->addressLineOne, "addressLineTwo" => $this->addressLineTwo, "city" => $this->city, "state" => $this->state,
			"zipCode" => $this->zipCode, "email" => $this->email, "phoneNumber" => $this->phoneNumber, "hash" => $this->hash,
			"salt" => $this->salt, "userId" => $this->userId);
		$statement->execute($parameters);
	}

	/**
	 * Get user by userId integer
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @param int for unique userId $userId
	 * @return mixed|User
	 **/
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
			$user = null;
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$row   = $statement->fetch();
			if($row !== false) {
				$user = new User ($row["userId"], $row["lastName"], $row["firstName"], $row["root"], $row["attention"],
					$row["addressLineOne"], $row["addressLineTwo"], $row["city"], $row["state"], $row["zipCode"],
					$row["email"], $row["phoneNumber"], $row["salt"], $row["hash"]);
			}
		} catch(Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new PDOException($exception->getMessage(), 0, $exception));
		}
		return($user);
	}

	/**
	 * get user by email
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @param mixed info for $user
	 * @return null|User
	 **/
	public static function getUserByEmail(PDO &$pdo, $user) {
		// sanitize the email before searching
		$user = filter_var($user, FILTER_SANITIZE_EMAIL);
		if($user === false) {
			throw(new PDOException(""));

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
				$user = new User ($row["userId"], $row["lastName"], $row["firstName"], $row["root"], $row["attention"],
								$row["addressLineOne"], $row["addressLineTwo"], $row["city"], $row["state"], $row["zipCode"],
								$row["email"], $row["phoneNumber"], $row["salt"], $row["hash"]);
			}
		} catch(Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new PDOException($exception->getMessage(), 0, $exception));
		}
		return($user);
	}
}










