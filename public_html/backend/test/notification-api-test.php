<?php
// grab the project test parameters
require_once("inventorytext.php");

// grab the autoloader for all Composer classes
require_once(dirname(dirname(dirname(__DIR__))) . "/vendor/autoload.php");

// grab the class(s) under scrutiny
require_once(dirname(__DIR__) . "/php/classes/autoload.php");
/**
 * Full PHPUnit test for the Notification API
 *
 * This is a complete PHPUnit test of the Notification class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Notificaiton/index.php
 * @author James Huber <jhuber8@cnm.edu>
 **/
class NotificationAPITest extends InventoryTextTest {
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
	protected $INVALID_notificationDateTime = null;
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
	 * test grabbing a notification by valid notificationId
	 **/
	public function testGetValidNotificationByNotificationId() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("notification");

		// create a new vendor and insert to into mySQL
		$newNotification = new Notification(null, $this->alertLevel->getAlertId(), $this->VALID_emailStatus, $this->VALID_notificationDateTime, $this->VALID_notificationHandle, $this->VALID_notificationContent);
		$newNotification->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$response = $this->guzzle->get('http://bootcamp-coders.cnm.edu/~invtext/backend/php/api/notification/?notificationId=' . $newNotification->getNotificationId());
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		$notification = json_decode($body);
		$this->assertSame(200, $notification->status);
	}
	/**
	 * test grabbing a notification by  invalid notification id
	 **/
	public function testGetInvalidNotificationByNotificationId() {
		// grab the data from mySQL and enforce the fields match our expectations
		$response = $this->guzzle->get('http://bootcamp-coders.cnm.edu/~invtext/backend/php/api/notification/?notificationId=' . InventoryTextTest::INVALID_KEY);
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		$notification = json_decode($body);
		$this->assertSame(200, $notification->status);
	}
		/**
	 * test grabbing a notification by valid email status
	 **/
	public function testGetValidNotificationByEmailStatus() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("notification");

		// create a new notification and insert to into mySQL
		$newNotification = new Notification(null, $this->alertLevel->getAlertId(), $this->VALID_emailStatus, $this->VALID_notificationDateTime, $this->VALID_notificationHandle, $this->VALID_notificationContent);
		$newNotification->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$response = $this->guzzle->get('http://bootcamp-coders.cnm.edu/~invtext/backend/php/api/notification/?emailStatus=' . $newNotification->getEmailStatus());
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		$notification = json_decode($body);
		$this->assertSame(200, $notification->status);
	}
	/**
	 * test grabbing a notification by invalid emailStatus
	 **/
	public function testGetInvalidNotificationByEmailStatus() {
		// grab the data from mySQL and enforce the fields match our expectations
		$response = $this->guzzle->get('http://bootcamp-coders.cnm.edu/~invtext/backend/php/api/notification/?emailStatus=' . InventoryTextTest::INVALID_KEY);
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		$notification = json_decode($body);
		$this->assertSame(200, $notification->status);
	}

	/**
	 * test grabbing a notification by notificationDateTime
	 **/
	public function testGetValidNotificationByNotificationDateTime() {
		// create a new notification and insert to into mySQL
		$newNotification = new Notification(null, $this->alertLevel->getAlertId(), $this->VALID_emailStatus, $this->VALID_notificationDateTime, $this->VALID_notificationHandle, $this->VALID_notificationContent);
		$newNotification->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$angularDate = $newNotification->getNotificationDateTime()->getTimestamp() * 1000;
		$response = $this->guzzle->get('http://bootcamp-coders.cnm.edu/~invtext/backend/php/api/notification/?notificationDateTime=' . $angularDate);
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		$notification = json_decode($body);
		$this->assertSame(200, $notification->status);
	}
	/**
	 * test grabbing a notification by invalid notificationDateTime
	 **/
	public function testGetInvalidNotificationByNotificationDateTime() {
	// grab the data from mySQL and enforce the fields match our expectations
		$angularDate = $this->VALID_notificationDateTime->getTimestamp() * 1000;
		$response = $this->guzzle->get('http://bootcamp-coders.cnm.edu/~invtext/backend/php/api/notification/?date=' . $angularDate);
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		$notification = json_decode($body);
		$this->assertSame(200, $notification->status);
	}

	/**
	 *test posting a Notification
	 **/
	public function testPostValidNotification(){
		//creat a new Notification
		$newNotification = new Notification(null, $this->alertLevel->getAlertId(), $this->VALID_emailStatus, $this->VALID_notificationDateTime, $this->VALID_notificationHandle, $this->VALID_notificationContent);

		//run a get request to establish session tokens
		$this->guzzle->get('http://bootcamp-coders.cnm.edu/~invtext/backend/php/api/notification/?page=0');

		// grab the data from guzzle and enforce the status matches our expectations
		$response = $this->guzzle-> post('http://bootcamp-coders.cnm.edu/~invtext/backend/php/api/notification/', ['headers' => ['X-XSRF-TOKEN' => $this->getXsrfToken()], 'json' => $newNotification]);
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		$notification = json_decode($body);
		$this->assertSame(200, $notification->status);
	}
}

