<?php
/**
 * this is the alertLevel class for the inventoryText capstone project
 *
 * this alertLevel class will configure the user preferences for alerts, including how oftern and what the alert tells
 * the customer.
 *
 * @author James Huber <jhuber8@cnm.edu>
 **/
class AlertLevel {
	/**
	 * id for this alert level class, this is the primary key
	 * @var int $alertId
	 **/
	private $alertId;
	/**
	 *this is the alert type
	 * @var string $alertCode
	 **/
	private $alertCode;
	/**
	 *this tells how often an alert will be sent to user
	 * @var string $alertFrequency
	 **/
	private $alertFrequency;
	/**
	 *this is the quantity at which the user will receive an alert (set by user)
	 * @var string $alertLevel
	 **/
	private $alertLevel;
	/**
	 * this sets whether an notification will be sent at more or less than the alert level
	 * @var string $alertOperator
	 **/
	private $alertOperator;

	/**
	 * constructor for alert level
	 *
	 * @param int $newAlertId id for alert level or null if unknown alert level
	 * @param string $newAlertCode string containing data on alert type
	 * @param string $newAlertFrequency string containing data on how ofter a user will receive an alert
	 * @param string $newAlertLevel string containing data on the quantity at which a user will receive notification
	 * @param string $newAlertOperator string containing data on whether an alert will be sent at more or less that alert level
	 * @throws InvalidArgumentException if data types are not valid
	 * @throws RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws Exception if any other Exceptions are thrown
	 **/
	public function __construct($newAlertId, $newAlertCode, $newAlertFrequency, $newAlertLevel, $newAlertOperator=null) {
		try {
			$this->setAlertId($newAlertId);
			$this->setAlertCode($newAlertCode);
			$this->setAlertFrequency($newAlertFrequency);
			$this->setAlertLevel($newAlertLevel);
			$this->setAlertOperator($newAlertOperator);
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
 * accessor method for alert id
 *
 * @return mixed value of alert id
 **/
public function getAlertid (){
	return($this->alertId);
}
/**
 * mutator method for alert id
 *
 * @param mixed $AlertId new value of alert id
 * @throw InvalidArgumentException if $alertId is not an integer
 * @throw RangeException if $alertId is not positive
 **/
	public function setAlertId($newAlertId){
		//base case: if the alert id is null, this is a new alert without a mySQL assigned id (yet)
		if($newAlertId===null){
			$this->alertId=null;
			return;
		}
		//verify the alert id is valid
		$newAlertId=filter_var($newAlertId, FILTER_VALIDATE_INT);
		if($newAlertId===false){
			throw(new InvalidArgumentException("alert id is not a valid integer"));
		}
		// verify the alert id is positive
		if($newAlertId<=0){
			throw(new RangeException("alert id is not positive"));
		}
		//convert and store the alert id
		$this->alertId=intval($newAlertId);
	}
/**accessor method for alert code
 *
 * @return mixed value for alert code
 **/
	public function getAlertCode(){
		return($this->alertId);
	}
/**
 * mutator method for alert code
 *
 * @param string $newAlertCode new value of alert code
 * @throws InvalidArgumentException if $newAlertCode is not a string or insecure
 * @throws RangeException if $newAlertCode is < 2
 * @throws RangeException if $newAlertCode is >5
 **/
	public function setAlertCode ($newAlertCode){
		//varify the alert code is secure
		$newAlertCode=trim($newAlertCode);
		$newAlertCode=filter_var($newAlertCode, FILTER_SANITIZE_STRING);
		if(empty($newAlertCode)=== true){
			throw(new InvalidArgumentException("alert code is empty or insecure"));
		}
		//verify the alert code will fit in the database
		if(strlen($newAlertCode)<2){
			throw(new RangeException("alert code is to small"));
		}
		if(strlen($newAlertCode)>5){
			throw(new RangeException("alert code is too large"));
		}
		//store the alert code
		$this->alertCode=$newAlertCode;
	}
/**
 * accessor method for alert frequency
 *
 * @return mixed value for alert frequency
 **/
	public function getAlertFrequency(){
		return($this->alertFrequency);
	}
/**
 * mutator method for alert frequency
 *
 * @param string $newAlertFrequency value of alert frequency
 * @throws InvalidArgumentException if $newAlertFrequency is not a string or insecure
 * @throws RangeException if $newAlertFrequency is > 10 characters
 **/
	public function setAlertFrequency($newAlertFrequency){
		//verify alert frequency is secure
		$newAlertFrequency=trim($newAlertFrequency);
		$newAlertFrequency=filter_var($newAlertFrequency. FILTER_SANITIZE_STRING);
		if(empty($newAlertFrequency)=== true){
			throw(new InvalidArgumentException("alert frequency is empty or insecure"));
		}
		//verify alert frequency will fit into database
		if(strlen($newAlertFrequency)>10){
			throw(new RangeException("alert frequency is too large"));
		}
		//store alert frequency
		$this->alertFrequency=$newAlertFrequency;
	}
/**
 * accessor method for alert level
 *
 * @return string value for alert level
 **/
	public function getAlertLevel(){
		return($this->alertLevel);
	}
/**
 * mutator method for alert level
 *
 * @param string $newAlertLevel value of alert level
 * @throws InvalidArgumentException if $newAlertLevel is not a string or insecure
 * @throws RangeException if $newAlertLevel is >10 characters
 **/
	public function setAlertLevel($newAlertLevel) {
		//verify alert level is secure
		$newAlertLevel = trim($newAlertLevel);
		$newAlertLevel = filter_var($newAlertLevel, FILTER_SANITIZE_STRING);
		if(empty($newAlertLevel) === true) {
			throw(new InvalidArgumentException("alert level is empty or insecure"));
		}
		//verify alert level will fit into database
		if(strlen($newAlertLevel) > 10) {
			throw(new RangeException("alert level is too large"));
		}
		//store alert level
		$this->alertLevel = $newAlertLevel;
	}
/**
 * accessor method for alert operator
 *
 * @return string value for alert operator
 **/
	public function getAlertOperator() {
		return ($this->alertOperator);
	}
/**
 * mutator method for alert operator
 *
 * @param string $newAlertOperator value of alert operator
 * @return InvalidArgumentException if $newAlertOperator is not a string or insecure
 * @return RangeException if @newAlertOperator is >10 characters
 **/
	public function setAlertOperator($newAlertOperator){
		//verify alert opertator is secure
		$newAlertOperator=trim($newAlertOperator);
		$newAlertOperator=filter_var($newAlertOperator, FILTER_SANITIZE_STRING);
		if(empty($newAlertOperator)=== true){
			throw(new InvalidArgumentException("alert operator is empty or insecure"));
		}
		//verify alert operator will fit into database
		if(strlen($newAlertOperator)>10){
			throw(new RangeException("alert level is too large"));
		}
		//store alert operator
		$this->alertLevel=$newAlertOperator;
	}
}