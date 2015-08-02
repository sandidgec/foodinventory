<?php
/**
 * this is the vendor class for the inventoryText capstone project
 *
 * this vendor class will track which inventory items come from which vendors and where to reorder each item. it will also
 * contain contact information and lead time, which will be the average time between placing an order and receiving order items
 *
 * @author James Huber <jhuber8@cnm.edu>
 **/
class Vendor {
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
		//verify the contact name is secur
		$newContactName=trim($newContactName);
		$newContactName=filter_var($newContactName, FILTER_SANITIZE_STRING);
		if(empty($newContactName)===true){
			throw(new InvalidArgumentException("contact names is empty or insecure"));
		}
		//verify the contact name will fit into database
		if(strlen($newContactName)>64){
			throw(new RangeException("contact name is too large"));
		}
		//store the contact name
		$this->contactName=$newContactName;
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
		$newVendorName=trim($newVendorName);
		$newVendorName=filter_var($newVendorName, FILTER_SANITIZE_STRING);
		if(empty($newVendorName)===true){
			throw(new InvalidArgumentException("vendor name is empty or insecure"));
		}
		//verify the vendor name will fit into database
		if(strlen($newVendorName)>64){
			throw(new RangeException("vendor name is too large"));
		}
		//store vendor name
		$this->vendorName=$newVendorName;
	}
	/**
	* accessor method for vendor phone number
	 * @return int value for vendor phone mumber
	 **/
	public function getVendorPhoneNummber(){
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
		if((ctype_digit($newVendorPhoneNumber))===false){
			throw(new InvalidArgumentException("vendor phone number is invalid"));
		}
		if(strlen($newVendorPhoneNumber)>10){
			throw(new RangeException("vendor phone number is formatted 5555555555"));
		}
		$this->vendorPhoneNumber=$newVendorPhoneNumber;
	}
}