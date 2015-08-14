<?php
// grab the project test parameters
require_once("inventorytext.php");

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/php/classes/notification.php");
require_once(dirname(__DIR__) . "/php/classes/alert-level.php");

/**
 * Full PHPUnit test for the Notification class
 *
 * This is a complete PHPUnit test of the Notification class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Notificaiton
 * @author James Huber <jhuber8@cnm.edu>
 **/
class NotificationTest extends InventoryTextTest {
	/**
	 * valid at notification id to use
	 * @var int $VALID_notificationId
	 **/
	protected $VALID_notificationId = "69";
	/**
	 * invalid notification id to use
	 * @var int $INVALID_notificationId
	 **/
	protected $INVALID_notificationId = "4294967296";
	/**
	 * valid alert id to use
	 * @var int $VALID_alertId
	 **/
	protected $VALID_alertId = "69";
	/**
	 * valid email status to use
	 * @var int $VALID_emailStatus
	 **/
	protected $VALID_emailStatus = true;
	/**
	 * invalid email status to use
	 * @var int $VALID_emailStatus
	 **/
	protected $INVALID_emailStatus = "4294967296";
	/**
	 * valid notification date and time to use
	 * @var dateTime $VALID_notificationDateTime
	 **/
	protected $VALID_notificationDateTime = null;
	/**
	 * invalid notification date time to use
	 * @var dateTime $INVALID_notificationDateTime
	 **/
	protected $INVALID_notificationDateTime = "06/1985/28 4:26:03";
	/**
	 * valid notification handle to use
	 * @var string $VALID-notificationHandle
	 */
	protected $VALID_notificationHandle = "unit test";
	/**
	 * second valid notification to use
	 * @var string $VALID_notificationHandle2
	 */
	protected $VALID_notificationHandle2 = "unittest2";
	/**
	 * invalid notification handle to use
	 * @var string $INVALID_notificationHandle
	 **/
	protected $INVALID_notificationHandle = "this is only a test";
	/**
	 * valid notification content to use
	 * @var string $VALID_notificationContent
	 **/
	protected $VALID_notificationContent = "This is a test of the emergency broadcast system. This is only a test";
	/**
	 * invalid notification content to use
	 * @var string $INVALID_notificationContent
	 **/
	protected $INVALID_notificationContent = "place holder cause Topher doesn't know";

	/**
	 * seting up for Foreign key alert id
	 * @var AlertLevel $alertLevel
	 **/
	protected $alertLevel = null;

	public function setUp() {
		parent::setUp();

		$alertId = null;
		$alertCode = "33";
		$alertFrequency = "11";
		$alertLevel = "100.01";
		$alertOperator = "1";

		$this->alertLevel = new AlertLevel($alertId, $alertCode, $alertFrequency, $alertLevel, $alertOperator);
		$this->alertLevel->insert($this->getPDO());

		$this->VALID_notificationDateTime = DateTime::createFromFormat("Y-m-d H:i:s", "1985-06-28 04:26:03");

	}
	/**
	 * test inserting a valid Notification and verify that the actual mySQL data matches
	 **/
	public function testInsertValidNotification() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("notification");

		// create a new Notification and insert to into mySQL
		$notification = new Notification (null, $this->alertLevel->getAlertId(), $this->VALID_emailStatus, $this->VALID_notificationDateTime, $this->VALID_notificationHandle, $this->VALID_notificationContent);
		$notification->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoNotification = Notification::getNotificationByNotificationId($this->getPDO(), $notification->getNotificationId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("notification"));
		$this->assertSame($pdoNotification->getAlertId(), $this->alertLevel->getAlertId());
		$this->assertSame($pdoNotification->getEmailStatus(), $this->VALID_emailStatus);
		$this->assertEquals($pdoNotification->getNotificationDateTime(), $this->VALID_notificationDateTime);
		$this->assertSame($pdoNotification->getNotificationHandle(), $this->VALID_notificationHandle);
		$this->assertSame($pdoNotification->getNotificationContent(), $this->VALID_notificationContent);
	}

	/**
	 * test inserting a Notification that already exists
	 *
	 * @expectedException PDOException
	 **/
	public function testInsertInvalidNotification() {
		// create a notification with a non null notificationId and watch it fail
		$notification = new Notification(InventoryTextTest::INVALID_KEY, $this->VALID_alertId, $this->VALID_emailStatus, $this->VALID_notificationDateTime, $this->VALID_notificationHandle, $this->VALID_notificationContent);
		$notification->insert($this->getPDO());
	}

	/**
	 * test inserting a Notification and regrabbing it from mySQL
	 **/
	public function testGetValidNotificationByNotificationId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("notification");

		// create a new Notification and insert to into mySQL
		$notification = new Notification(null, $this->alertLevel->getAlertId(), $this->VALID_emailStatus, $this->VALID_notificationDateTime, $this->VALID_notificationHandle, $this->VALID_notificationContent);
		$notification->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoNotification = Notification::getNotificationByNotificationId($this->getPDO(), $notification->getNotificationId());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("notification"));
		$this->assertSame($pdoNotification->getAlertId(), $this->alertLevel->getAlertId());
		$this->assertSame($pdoNotification->getEmailStatus(), $this->VALID_emailStatus);
		$this->assertEquals($pdoNotification->getNotificationDateTime(), $this->VALID_notificationDateTime);
		$this->assertSame($pdoNotification->getNotificationHandle(), $this->VALID_notificationHandle);
		$this->assertSame($pdoNotification->getNotificationContent(), $this->VALID_notificationContent);
	}

	/**
	 * test grabbing a Notification that does not exist
	 **/
	public function testGetInvalidNotificationByNotificationId() {
		// grab a notification id that exceeds the maximum allowable notification id
		$notification = Notification::getNotificationByNotificationId($this->getPDO(), InventoryTextTest::INVALID_KEY);
		$this->assertNull($notification);
	}

	/**
	 * test grabbing a notification by alert id
	 **/
	public function testGetValidNotificationByAlertId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("notification");

		// create a new notification and insert to into mySQL
		$notification = new Notification(null, $this->alertLevel->getAlertId(), $this->VALID_emailStatus, $this->VALID_notificationDateTime, $this->VALID_notificationHandle, $this->VALID_notificationContent);
		$notification->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoNotification = Notification::getNotificationByAlertId($this->getPDO(), $this->alertLevel->getAlertId());
		foreach($pdoNotification as $note) {
			$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("notification"));
			$this->assertSame($note->getAlertId(), $this->alertLevel->getAlertId());
			$this->assertSame($note->getEmailStatus(), $this->VALID_emailStatus);
			$this->assertEquals($note->getNotificationDateTime(), $this->VALID_notificationDateTime);
			$this->assertSame($note->getNotificationHandle(), $this->VALID_notificationHandle2);
			$this->assertSame($note->getNotificationContent(), $this->VALID_notificationContent);
		}
	}

	/**
	 * test grabbing a notification by an alert id that does not exists
	 **/
	public function testGetInvalidNotificationByAlertId() {
		// grab an alert id that does not exist
		$notification = Notification::getNotificationByAlertId($this->getPDO(), "4294967296");
		$this->assertNull($notification);
	}
	/**
	 * test grabbing a notification by email status
	 **/
	public function testGetValidNotificationByEmailStatus() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("notification");

		// create a new notification and insert to into mySQL
		$notification = new Notification(null, $this->alertLevel->getAlertId(), $this->VALID_emailStatus, $this->VALID_notificationDateTime, $this->VALID_notificationHandle, $this->VALID_notificationContent);
		$notification->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoNotification = Notification::getNotificationByEmailStatus($this->getPDO(), $this->VALID_emailStatus);
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("notification"));
		$this->assertSame($pdoNotification->getAlertId(), $this->alertLevel->getAlertId());
		$this->assertSame($pdoNotification->getEmailStatus(), $this->VALID_emailStatus);
		$this->assertEquals($pdoNotification->getNotificationDateTime(), $this->VALID_notificationDateTime);
		$this->assertSame($pdoNotification->getNotificationHandle(), $this->VALID_notificationHandle);
		$this->assertSame($pdoNotification->getNotificationContent(), $this->VALID_notificationContent);
	}

	/**
	 * test grabbing a notification by an alert id that does not exists
	 **/
	public function testGetInvalidNotificationByEmailStatus() {
		// grab an email id that does not exist
		$notification = Notification::getNotificationByAlertId($this->getPDO(), "4294967296");
		$this->assertNull($notification);
	}
}