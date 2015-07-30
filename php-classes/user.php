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
	 * Constructor for User Id
	 *
	 * @param $newUserId
	 * @param $newLastName
	 * @param $newFirstName
	 * @param $newEmail
	 * @param $newSalt
	 * @param $newHash
	 */
	public
	function __construct($newUserId, $newLastName, $newFirstName, $newEmail, $newSalt, $newHash) {
		try {
			$this->setUserId($newUserId);
			$this->setLastName($newLastName);
			$this->setFirstName($newFirstName);
			$this->setEmail($newEmail);
			$this->setSalt($newSalt);
			$this->setHash($newHash);
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
}






