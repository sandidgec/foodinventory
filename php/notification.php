<?php
/**
 * this is the notification class for the inventoryText capstone project
 *
 * this notification class will interact with twillio, sending out notifications to twillio to send out a text
 * and also receiving and interpreting  information sent via the twillio app, from the end user.
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
	 * this is the id for messages from twillio, this is a foreign key
	 * @var int $twillioId
	 **/
	private $twillioId;
	/**
	 *this is the time stamp for every notification
	 * @var string $dateTime
	 **/
	private $dateTime;
	/**
	 * this is the data sent from twillio for specific requests from user
	 * @var string $notificationHandle
	 **/
	private $notificationHandle;
	/**
	 * this is the content of the notifications telling customer specific information on their
	 * @var string $notificationContent
	 **/
	private $notificationContent;
	/**
	 * constructor for this Notification
	 *
	 * @param mixed $newNotificationId id of this Notification or null if unknown notification
	 * @param int $newAlertId id for alert level sent with this notification
	 * @param int $newTwillioId id sent from twillio for each notification
	 * @param string $newDateTime date and time of when each notification was sent or null if set to current date and time
	 * @param string $newNotificationHandle string containing data from twillio for notification
	 * @param string $newNotificationContent string containing conent of notification
	 * @throws InvalidArgumentException if data types are not valid
	 * @throws RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 **/
	public function __construct($newNotificationId, $newAlertId, $newTwillioId, $newDateTime, $newNotificationHandle,
										 $newNotificationContent = null) {
		try {
			$this->setNotificationId($newNotificationId);
			$this->setAlertId($newAlertId);
			$this->setTwillioId($newTwillioId);
			$this->setDateTime($newDateTime);
			$this->setNotificationHandle($newNotificationHandle);
			$this->setNotificationContent($newNotificationContent);
		} catch(InvalidArgumentException $invalidArgument) {
			// rethrow the exception to the caller
			throw(new InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(RangeException $range) {
			// rethrow the exception to the caller
			throw(new RangeException($range->getMessage(), 0, $range));
		} catch (Exception $exception) {
			//rethrow generic mysqli_sql_exception
			throw(new Exception($exception->getMessage(), 0, $exception));
		}
	}
/**
/**
 * accessor method for notification id
 *
 * @return mixed value of notification id
 **/
public function getnotificationId() {
	return ($this->notificationId);
}
	/**
 	* mutator method for notification id
 	*
 	* @param mixed $NotificationId new value of notification id
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