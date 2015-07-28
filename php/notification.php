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
	 *
	 **/
	private $alertId;
	/**
	 *this is the time stamp for every notification
	 * @var string $dateTime
	 **/
	private $dateTime;
	/**
	 * this is the data sent from twillio for specific requests from user
	 * @var string $noteHandle
	 **/
	private $noteHandle;
	/**
	 * this is the content of the notifications telling customer specific information on their
	 * @var string $notificationContent
	 **/
	private $notificationContent;
	/**
	 * this
	 * @var
	 **/
	private $twillioId;
	/**
	 * this
	 */
}