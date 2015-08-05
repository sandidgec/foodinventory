<?php

require_once("/home/jhuber8/public_html/foodinventory/php/traits/validateDate.php");

/**
 * this is the notification class for the inventoryText capstone project
 *
 * this notification class will sending out notifications via email, user can set frequency, content and which inventory
 * items will trigger notifications
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
	 * this is the confirmation status for each email sent
	 * @var int $emailStatus
	 **/
	private $emailStatus;
	/**
	 *this is the time stamp for every notification
	 * @var dateTime $notificationDateTime
	 **/
	private $notificationDateTime;
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

	use validateDate;

	/**
	 * constructor for this Notification
	 *
	 * @param int $newNotificationId id of this Notification or null if unknown notification
	 * @param int $newAlertId id for alert level sent with this notification
	 * @param int $newEmailStatus confirmation status for sent emails
	 * @param dateTime $newNotificationDateTime date and time of when each notification was sent or null if set to current date and time
	 * @param string $newNotificationHandle string containing data from twilio for notification
	 * @param string $newNotificationContent string containing conent of notification
	 * @throws InvalidArgumentException if data types are not valid
	 * @throws RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws Exception if some other exception is thrown
	 **/
	public function __construct($newNotificationId, $newAlertId, $newEmailStatus, $newNotificationDateTime, $newNotificationHandle,
										 $newNotificationContent = null) {
		try {
			$this->setNotificationId($newNotificationId);
			$this->setAlertId($newAlertId);
			$this->setEmailStatus($newEmailStatus);
			$this->setNotificationDateTime($newNotificationDateTime);
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
	 * accessor method for email status
	 *
	 * @return mixed value of email status
	 **/
	public function getEmailStatus() {
		return ($this->emailStatus);
	}

	/**
	 * mutator method for email status
	 *
	 * @param int $newEmailStatus new value of email status
	 * @throws InvalidArgumentException if $newEmailStatus is not an integer
	 * @throws RangeException if $newEmailStatus is not positive
	 **/
	public function setEmailStatus($newEmailStatus) {
		// base case: if the email status is null, this a new alert without a mySQL assigned id (yet)
		if($newEmailStatus === null) {
			$this->emailStatus = null;
			return;
		}

		// verify the email status is valid
		$newEmailStatus = filter_var($newEmailStatus, FILTER_VALIDATE_INT);
		if($newEmailStatus === false) {
			throw(new InvalidArgumentException("email status is not a valid integer"));
		}
		// verify the alert id is positive
		if($newEmailStatus <= 0) {
			throw(new RangeException("email is not positive"));
		}
		// convert and store the alert id
		$this->emailStatus = intval($newEmailStatus);
	}


	/**
	 * accessor method for notification date
	 *
	 * @return dateTime value of notification date
	 **/
	public function getNotificationDateTime() {
		return ($this->notificationDateTime);
	}

	/**
	 * mutator method for notification date and time
	 *
	 * @param mixed $newNotificationDateTime notification date as a DateTime object or string (or null to load the current time)
	 * @throws InvalidArgumentException if $newNotificationDateTime is not a valid object or string
	 * @throws RangeException if $newNotificationDateTime is a date that does not exist
	 **/
	public function setNotificationDateTime($newNotificationDateTime) {
		// base case: if the date is null, use the current date and time
		if($newNotificationDateTime === null) {
			$this->notificationDateTime = new DateTime();
			return;
		}

		// store the notification date
		try {
			$newNotificationDateTime = validateDate::validateDate($newNotificationDateTime);
		} catch(InvalidArgumentException $invalidArgument) {
			throw(new InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(RangeException $range) {
			throw(new RangeException($range->getMessage(), 0, $range));
		}
		$this->notificationDateTime = $newNotificationDateTime;
	}

	/**
	 * accessor method for notification handle
	 *
	 * @return mixed value of notification handle
	 **/
	public function getNotificationHangle() {
		return ($this->notificationHandle);
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
		$newNotificationHandle = trim($newNotificationHandle);
		$newNotificationHandle = filter_var($newNotificationHandle, FILTER_SANITIZE_STRING);
		if(empty($newNotificationHandle) === true) {
			throw(new InvalidArgumentException("notification handle is empty or insecure"));
		}
		//verify the notification handle will fit into database
		if(strlen($newNotificationHandle) > 10) {
			throw(new RangeException("notification handle is too large"));
		}
		//store the notification handle
		$this->notificationHandle = $newNotificationHandle;
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

	/**
	 * * inserts this Notification into mySQL
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @throws PDOException when mySQL related errors occur
	 **/
	public function insert(PDO &$pdo) {
		// enforce the notificationId is null (i.e., don't insert a notification that already exists)
		if($this->notificationId !== null) {
			throw(new PDOException("not a new notification"));
		}

		// create query template
		$query = "INSERT INTO notification(notificationId, alertId, emailStatus, notificationDateTime, notificationHandle, notificationContent)VALUES(:notificationId, :alertId, :emailStatus, :notificationDateTime, :notificationHandle, :notificationContent)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$formattedDate = $this->notificationDateTime->format("Y-m-d H:i:s");
		$parameters = array("notificationId" => $this->notificationId, "alertId" => $this->alertId, "emailStatus" => $this->emailStatus,
			"notificationDateTime" => $formattedDate, "notificationHandle" => $this->notificationHandle, "notificationContent" => $this->notificationContent);
		$statement->execute($parameters);

		// update the null notificationId with what mySQL just gave us
		$this->notificationId = intval($pdo->lastInsertId());
	}

	/**
 * gets the Notification by notificationId
 *
 * @param PDO $pdo pointer to PDO connection, by reference
 * @param int $notificationId notification id to search for
 * @return mixed notification found or null if not found
 * @throws PDOException when mySQL related errors occur
 **/
	public static function getNotificationByNotificationId(PDO &$pdo, $notificationId) {
		// sanitize the notificationId before searching
		$notificationId = filter_var($notificationId, FILTER_VALIDATE_INT);
		if($notificationId === false) {
			throw(new PDOException("notification id is not an integer"));
		}
		if($notificationId <= 0) {
			throw(new PDOException("notification id is not positive"));
		}

		// create query template
		$query = "SELECT notificationId, alertId, emailStatus, notificationDateTime, notificationHandle, notificationContent FROM notification WHERE notificationId = :notificationId";
		$statement = $pdo->prepare($query);

		// bind the notification id to the place holder in the template
		$parameters = array("notificationId" => $notificationId);
		$statement->execute($parameters);

		// grab the notification from mySQL
		try {
			$notification = null;
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$notification = new Notification($row["notificationId"], $row["alertId"], $row["emailStatus"], $row["notificationDateTime"], $row["notificationHandle"], $row["notificationContent"]);
			}
		} catch(Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new PDOException($exception->getMessage(), 0, $exception));
		}
		return ($notification);
	}
	/**
	 * gets the Notification by alertId
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @param int $alertId alert id to search for
	 * @return mixed notification found or null if not found
	 * @throws PDOException when mySQL related errors occur
	 **/
	public static function getNotificationByAlertId(PDO &$pdo, $alertId) {
		// sanitize the alertId before searching
		$alertId = filter_var($alertId, FILTER_VALIDATE_INT);
		if($alertId === false) {
			throw(new PDOException("alert id is not an integer"));
		}
		if($alertId <= 0) {
			throw(new PDOException("alert id is not positive"));
		}

		// create query template
		$query = "SELECT notificationId, alertId, emailStatus, notificationDateTime, notificationHandle, notificationContent FROM notification WHERE alertId = :alertId";
		$statement = $pdo->prepare($query);

		// bind the alert id to the place holder in the template
		$parameters = array("alertId" => $alertId);
		$statement->execute($parameters);

		// grab the notification from mySQL
		try {
			$notification = null;
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$notification = new Notification($row["notificationId"], $row["alertId"], $row["emailStatus"], $row["notificationDateTime"], $row["notificationHandle"], $row["notificationContent"]);
			}
		} catch(Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new PDOException($exception->getMessage(), 0, $exception));
		}
		return ($notification);
	}
	/**
	 * gets the Notification by emailStatus
	 *
	 * @param PDO $pdo pointer to PDO connection, by reference
	 * @param int $emailStatus email status to search for
	 * @return mixed notification found or null if not found
	 * @throws PDOException when mySQL related errors occur
	 **/
	public static function getNotificationByEmailStatus(PDO &$pdo, $emailStatus) {
		// sanitize the emailStatus before searching
		$emailStatus = filter_var($emailStatus, FILTER_VALIDATE_INT);
		if($emailStatus === false) {
			throw(new PDOException("email status is not an integer"));
		}
		if($emailStatus <= 0) {
			throw(new PDOException("email status is not positive"));
		}

		// create query template
		$query = "SELECT notificationId, alertId, emailStatus, notificationDateTime, notificationHandle, notificationContent FROM notification WHERE notificationId = :notificationId";
		$statement = $pdo->prepare($query);

		// bind the email id to the place holder in the template
		$parameters = array("emailStatus" => $emailStatus);
		$statement->execute($parameters);

		// grab the notification from mySQL
		try {
			$notification = null;
			$statement->setFetchMode(PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$notification = new Notification($row["notificationId"], $row["alertId"], $row["emailStatus"], $row["notificationDateTime"], $row["notificationHandle"], $row["notificationContent"]);
			}
		} catch(Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new PDOException($exception->getMessage(), 0, $exception));
		}
		return ($notification);
	}
}

