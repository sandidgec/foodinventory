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
		if(strlen($newLastName)> 32){
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
	public function setFirstName ($newFirstName) {
		// verify first name is valid
	$newFirstName = filter_var($newFirstName,FILTER_SANITIZE_STRING);
		if(empty($newFirstName) === true) {
			throw new InvalidArgumentException("content invalid");
		}
		if(strlen($newFirstName)> 32) {
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
	public function setEmail ($newEmail) {
		// verify email is valid
		$newEmail = filter_var($newEmail, FILTER_SANITIZE_EMAIL);
			if(empty($newEmail) === true) {
				throw new InvalidArgumentException ("content invalid");
			}
			if (strlen($newEmail)>64) {
				throw new RangeException ("Email content too large");
			}
		$this->email = $newEmail;
	}
}
