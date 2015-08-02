<?php
/**
 * this is the notification class for the inventoryText capstone project
 *
 * this notification class will interact with twilio, sending out notifications to twillio to send out a text
 * and also receiving and interpreting  information sent via the twilio app, from the end user.
 *
 * @author James Huber <jhuber8@cnm.edu>
 **/
class Notification {
	/**
	 * id for this notification, this is the primary key
	 * @var int $notificationId
	 **/
	private $notificationId;
	/**
	 * this is the id for alert level, this is a foreign key
	 * @var int $alertId
	 **/
	private $alertId;
	/**
	 * this is the id for each email for users notification, this is a foreign key
	 * @var int $emailId
	 **/
	private $emailId;
	/**
	 *this is the time stamp for every notification
	 * @var string $dateTime
	 **/
	private $dateTime;
	/**
	 * this is the data sent by email for specific requests from user
	 * @var string $notificationHandle
	 **/
	private $notificationHandle;
	/**
	 * this is the content of the notifications telling customer specific information on their inventory
	 * @var string $notificationContent
	 **/
	private $notificationContent;

	/**
	 * constructor for this Notification
	 *
	 * @param int $newNotificationId id of this Notification or null if unknown notification
	 * @param int $newAlertId id for alert level sent with this notification
	 * @param int $newEmailId id generated for each notification
	 * @param string $newDateTime date and time of when each notification was sent or null if set to current date and time
	 * @param string $newNotificationHandle string containing data from twilio for notification
	 * @param string $newNotificationContent string containing conent of notification
	 * @throws InvalidArgumentException if data types are not valid
	 * @throws RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws Exception if some other exception is thrown
	 **/
	public function __construct($newNotificationId, $newAlertId, $newEmailId, $newDateTime, $newNotificationHandle,
										 $newNotificationContent = null) {
		try {
			$this->setNotificationId($newNotificationId);
			$this->setAlertId($newAlertId);
			$this->setEmailId($newEmailId);
			$this->setDateTime($newDateTime);
			$this->setNotificationHandle($newNotificationHandle);
			$this->setNotificationContent($newNotificationContent);
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
	 * accessor method for notification id
	 *
	 * @return mixed value of notification id
	 **/
	public function getNotificationId() {
		return ($this->notificationId);
	}

	/**
	 * mutator method for notification id
	 *
	 * @param int $newNotificationId new value of notification id
	 * @throws InvalidArgumentException if $newNotificationId is not an integer
	 * @throws RangeException if $newNotificationId is not positive
	 **/
	public function setNotificationId($newNotificationId) {
		// base case: if the notification id is null, this a new notification without a mySQL assigned id (yet)
		if($newNotificationId === null) {
			$this->notificationId = null;
			return;
		}

		// verify the notification id is valid
		$newNotificationId = filter_var($newNotificationId, FILTER_VALIDATE_INT);
		if($newNotificationId === false) {
			throw(new InvalidArgumentException("notification id is not a valid integer"));
		}
		// verify the actor id is positive
		if($newNotificationId <= 0) {
			throw(new RangeException("notification id is not positive"));
		}
		// convert and store the notification id
		$this->notificationId = intval($newNotificationId);
	}

	/**
	 * accessor method for alert id
	 *
	 * @return mixed value of alert id
	 **/
	public function getAlertId() {
		return ($this->alertId);
	}

	/**
	 * mutator method for alert id
	 *
	 * @param int $newAlertId new value of alert id
	 * @throws InvalidArgumentException if $newAlertId is not an integer
	 * @throws RangeException if $newAlertId is not positive
	 **/
	public function setAlertId($newAlertId) {
		// base case: if the alert id is null, this a new alert without a mySQL assigned id (yet)
		if($newAlertId === null) {
			$this->alertId = null;
			return;
		}

		// verify the alert id is valid
		$newAlertId = filter_var($newAlertId, FILTER_VALIDATE_INT);
		if($newAlertId === false) {
			throw(new InvalidArgumentException("alert id is not a valid integer"));
		}
		// verify the alert id is positive
		if($newAlertId <= 0) {
			throw(new RangeException("alert id is not positive"));
		}
		// convert and store the alert id
		$this->alertId = intval($newAlertId);
	}

	/**
	 * accessor method for email id
	 *
	 * @return mixed value of email id
	 **/
	public function getEmailId() {
		return ($this->emailId);
	}

	/**
	 * mutator method for email id
	 *
	 * @param int $newEmailId new value of email id
	 * @throws InvalidArgumentException if $newEmailId is not an integer
	 * @throws RangeException if $newEmailId is not positive
	 **/
	public function setEmailId($newEmailId) {
		// base case: if the email id is null, this a new email id without a mySQL assigned id (yet)
		if($newEmailId === null) {
			$this->emailId = null;
			return;
		}

		// verify the email id is valid
		$newEmailId = filter_var($newEmailId, FILTER_VALIDATE_INT);
		if($newEmailId === false) {
			throw(new InvalidArgumentException("email id is not a valid integer"));
		}
		// verify the email id is positive
		if($newEmailId <= 0) {
			throw(new RangeException("email id is not positive"));
		}
		// convert and store the email id
		$this->emailId = intval($newEmailId);
	}

	/**
	 * accessor method for notification date
	 *
	 * @return DateTime value of notification date
	 **/
	public function getDateTime() {
		return ($this->dateTime);
	}

	/**
	 * mutator method for notification date and time
	 *
	 * @param mixed $newDateTime notification date as a DateTime object or string (or null to load the current time)
	 * @throws InvalidArgumentException if $newDateTime is not a valid object or string
	 * @throws RangeException if $newDateTime is a date that does not exist
	 **/
	public function setDateTime($newDateTime) {
		// base case: if the date is null, use the current date and time
		if($newDateTime === null) {
			$this->dateTime = new DateTime();
			return;
		}

		// store the notification date
		try {
			$newDateTime = valiDate($newDateTime);
		} catch(InvalidArgumentException $invalidArgument) {
			throw(new InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(RangeException $range) {
			throw(new RangeException($range->getMessage(), 0, $range));
		}
		$this->dateTime = $newDateTime;
	}
	/**
	 * accessor method for notification handle
	 *
	 * @return mixed value of notification handle
	 **/
	public function getNotificationHangle(){
		return($this->notificationHandle);
	}
	/**
	 * mutator method for notification handle
	 *
	 * @param string $newNotificationHandle new value of notification handle
	 * @throws InvalidArgumentException if $newNotificationHangle is not a string or insecure
	 * @throws RangeException if $newNotificationHandle is > 10 characters
	 **/
	public function setNotificationHandle($newNotificationHandle) {
		//verify the notification handle is secure
		$newNotificationHandle=trim($newNotificationHandle);
		$newNotificationHandle=filter_var($newNotificationHandle, FILTER_SANITIZE_STRING);
		if(empty($newNotificationHandle)=== true) {
			throw(new InvalidArgumentException("notification handle is empty or insecure"));
		}
		//verify the notification handle will fit into database
		if(strlen($newNotificationHandle)>10){
			throw(new RangeException("notification handle is too large"));
		}
		//store the notification handle
		$this->notificationHandle=$newNotificationHandle;
	}
	/**
	 * accessor method for notification content
	 *
	 * @return mixed value of notification content
	 **/
	public function getNotificationContent() {
		return ($this->notificationContent);
	}
	/**
	 * mutator method for notification content
	 *
	 * @param string $newNotificationContent new value of notification content
	 * @throws InvalidArgumentException if $newNotificationContent is not a string or insecure
	 * @throws RangeException if $newNotificationContent is > 160 characters
	 **/
	public function setNotificationContent($newNotificationContent) {
		// verify the notification content is secure
		$newNotificationContent = trim($newNotificationContent);
		$newNotificationContent = filter_var($newNotificationContent, FILTER_SANITIZE_STRING);
		if(empty($newNotificationContent) === true) {
			throw(new InvalidArgumentException("notification content is empty or insecure"));
		}

		// verify the notification content will fit in the database
		if(strlen($newNotificationContent) > 160) {
			throw(new RangeException("notification content too large"));
		}
		// store the notification content
		$this->notificationContent = $newNotificationContent;
	}
}
