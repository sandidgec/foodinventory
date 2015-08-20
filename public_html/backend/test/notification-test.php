<?php
// grab the project test parameters
require_once("inventorytext.php");

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/php/classes/autoload.php");

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
	 * creating a vendor
	 * @var Vendor $vendor
	 **/
	protected $vendor = null;

	/**
	 * seting up for Foreign key alert id
	 * @var AlertLevel $alertLevel
	 **/
	protected $alertLevel = null;

	/**
	 * creating a productAlert
	 * object for global scope
	 * @var ProductAlert $productAlert
	 **/
	protected $productAlert = null;

	/**
	 * creating a product
	 * object for global scope
	 * @var Product $product
	 **/
	protected $product = null;

	public function setUp() {
		parent::setUp();

		$vendorId = null;
		$contactName = "Trevor Rigler";
		$vendorEmail = "trier@cnm.edu";
		$vendorName = "TruFork";
		$vendorPhoneNumber = "5053594687";

		$vendor = new Vendor($vendorId, $contactName, $vendorEmail, $vendorName, $vendorPhoneNumber);
		$vendor->insert($this->getPDO());

		$productId = null;
		$vendorId = $vendor->getVendorId();
		$description = "A glorius bead to use";
		$leadTime = 10;
		$sku = "TGT354";
		$title = "Bead-Green-Blue-Circular";

		$this->product = new Product($productId, $vendorId, $description, $leadTime, $sku, $title);
		$this->product->insert($this->getPDO());

		$alertId = null;
		$alertCode = "33";
		$alertFrequency = "11";
		$alertLevel = "100.01";
		$alertOperator = "1";

		$this->alertLevel = new AlertLevel($alertId, $alertCode, $alertFrequency, $alertLevel, $alertOperator);
		$this->alertLevel->insert($this->getPDO());

		$productEnabled = true;

		$this->productAlert = new ProductAlert($this->alertLevel->getAlertId(), $this->product->getProductId(), $productEnabled);
		$this->productAlert->insert($this->getPDO());

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
	 * test grabbing a notification by an email status that does not exists
	 **/
	public function testGetInvalidNotificationByEmailStatus() {
		// grab an email id that does not exist
		$notification = Notification::getNotificationByAlertId($this->getPDO(), "4294967296");
			$this->assertNull($notification);
	}
	/**
	 * test grabbing an product by alert Id
	 **/
	public function testGetValidNotificationsByAlertId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("alertLevel");

		// create a new alert level and insert to into mySQL
//		$alertLevel = new AlertLevel(null, $this->alertLevel->getAlertCode(), $this->alertLevel->getAlertFrequency(), $this->alertLevel->getAlertPoint(), $this->alertLevel->getAlertOperator());
//		$alertLevel->insert($this->getPDO());

		// create a new alert level and insert to into mySQL
//		$productAlert = new ProductAlert($alertLevel->getAlertId(), $this->product->getProductId(), true);
//		$productAlert->insert($this->getPDO());
		var_dump($this->getConnection()->getRowCount("productAlert"));
		var_dump($this->productAlert);
		var_dump($this->alertLevel->getAlertId());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProductArray = Notification::getNotificationsByAlertId($this->getPDO(), $this->alertLevel->getAlertId());
		var_dump($pdoProductArray);
		for($i = 0; $i < count($pdoProductArray); $i++) {
			if($i === 0) {
				$this->assertSame($pdoProductArray[$i]->getAlertCode(), $this->alertLevel->getAlertCode());
				$this->assertSame($pdoProductArray[$i]->getAlertFrequency(), $this->alertLevel->getAlertFrequency());
				$this->assertSame($pdoProductArray[$i]->getAlertPoint(), $this->alertLevel->getAlertPoint());
				$this->assertSame($pdoProductArray[$i]->getAlertOperator(), $this->alertLevel->getAlertOperator());
			} else {
				$this->assertSame($pdoProductArray[$i]->getProductId(), $this->product->getProductId());
				$this->assertSame($pdoProductArray[$i]->getVendorId(), $this->product->getVendorId());
				$this->assertSame($pdoProductArray[$i]->getDescription(), $this->product->getDescription());
				$this->assertSame($pdoProductArray[$i]->getSku(), $this->product->getSku());
				$this->assertSame($pdoProductArray[$i]->getTitle(), $this->product->getTitle());
			}
		}
	}
	/**
	 * test grabbing all Notifications
	 **/
	public function testGetValidAllNotifications() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("notification");

		// create a new notification and insert to into mySQL
		$notification = new Notification (null, $this->alertLevel->getAlertId(), $this->VALID_emailStatus, $this->VALID_notificationDateTime, $this->VALID_notificationHandle, $this->VALID_notificationContent);
		$notification->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoNotification = Notification::getAllNotification($this->getPDO(), $this->VALID_notificationId);
		foreach($pdoNotification as $note) {
			$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("notification"));
			$this->assertSame($note->getAlertId(), $this->alertLevel->getAlertId());
			$this->assertSame($note->getEmailStatus(), $this->VALID_emailStatus);
			$this->assertEquals($note->getNotificationDateTime(), $this->VALID_notificationDateTime);
			$this->assertSame($note->getNotificationHandle(), $this->VALID_notificationHandle2);
			$this->assertSame($note->getNotificationContent(), $this->VALID_notificationContent);
		}
	}

}