<?php
require_once(dirname(dirname(__DIR__)) . "/classes/autoload.php");
require_once(dirname(dirname(__DIR__)) . "/lib/xsrf.php");
require_once("/etc/apache2/data-design/encrypted-config.php");

// start the session and create a XSRF token
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

// prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	// determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	// sanitize the notification id
	$notificationId = filter_input(INPUT_GET, "notificationId", FILTER_VALIDATE_INT);

	//sanitize the email status
	if(isset($_GET["emailStatus"]) === true) {
		$emailStatus = filter_input(INPUT_GET, "emailStatus", FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
	} else {
		$emailStatus = null;
	}

	//sanitize the date
	$notificationDateTime = filter_input(INPUT_GET, "notificationDateTime", FILTER_VALIDATE_INT);

	//sanitize the page
	$alertId = filter_input(INPUT_GET, "alertId", FILTER_VALIDATE_INT);

	// sanitize the page
	$page = filter_input(INPUT_GET, "page", FILTER_VALIDATE_INT);

	// grab the mySQL connection
	$pdo = connectToEncryptedMySql("/etc/apache2/capstone-mysql/invtext.ini");

	// handle all RESTful calls to Notification
	// get some or all Notification
	if($method === "GET") {
		// set an XSRF cookie on GET requests
		setXsrfCookie("/");
		if(empty($notificationId) === false) {
			$reply->data = Notification::getNotificationByNotificationId($pdo, $notificationId);
		} else if(is_bool($emailStatus) === true) {
			$reply->data = Notification::getNotificationByEmailStatus($pdo, $emailStatus);
		} else if(empty($notificationDateTime) === false) {
			$notificationDateTimeInt = new DateTime();
			$notificationDateTimeInt->setTimestamp($notificationDateTime / 1000);
			$reply->data = Notification::getNotificationByNotificationDateTime($pdo, $notificationDateTimeInt);
		}	else if(empty($alertId) === false){
			$reply->data = Notification::getProductByAlertId($pdo, $alertId);
		} else if($page >= 0) {
			$notifications = Notification::getAllNotifications($pdo, $page)->toArray();
			foreach($notifications as $index => $notification) {
				$product = null;
				$productAlert = ProductAlert::getProductAlertByAlertId($pdo, $notification->getAlertId());
				if($productAlert !== null) {
					$product = Product::getProductByProductId($pdo, $productAlert->getProductId());
				}
				$notifications[$index] = json_decode(json_encode($notification));
				$notifications[$index]->product = $product;
			}
			$reply->data = $notifications;
		} else {
			throw(new InvalidArgumentException("no parameters given", 405));
		}

		// post to a new Notification
	} else if($method === "POST") {
		// convert POSTed JSON to an object
		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		$notificationDateTime = new DateTime();
		$notificationDateTime-> setTimestamp($requestObject->notificationDateTime / 1000);

		$notification = new Notification(null, $requestObject->alertId, $requestObject->emailStatus, $requestObject->notificationDateTime,
			$requestObject->notificationHandle, $requestObject->notificationContent);
		$notification->insert($pdo);
		$reply->data = "Notification created OK";
	}
// create an exception to pass back to the RESTful caller
} catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
	unset($reply->data);
}

header("Content-type: application/json");
echo json_encode($reply);