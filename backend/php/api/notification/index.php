<?php
require_once(dirname(dirname(dirname(__DIR__))) . "/lib/php/xsrf.php");
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
	if(($method === "DELETE" || $method === "PUT") && (empty($notificationId) === true || $notificationId < 0)) {
		throw(new InvalidArgumentException("notificationId cannot be empty or negative", 405));
	}
	//sanitize the email status
	$emailStatus = filter_input(INPUT_GET,"emailStatus", FILTER_VALIDATE_BOOLEAN);
	if(($method === "DELETE" || $method === "PUT") && (empty($emailStatus) === true || $emailStatus < 0)) {
		throw(new InvalidArgumentException("emailStatus cannot be empty or negative", 405));
	}
	//sanitize the date
	$date = filter_input(INPUT_GET, "date", FILTER_VALIDATE_INT);
	if(($method === "DELETE" || $method === "PUT") && (empty($date) === true || $date < 0)) {
		throw(new InvalidArgumentException("date cannot be empty or negative", 405));
	}
	//sanitize the productId
	$alertId = filter_input(INPUT_GET, "alertId", FILTER_VALIDATE_INT);
	if(($method === "DELETE" || $method === "PUT") && (empty($alertId) === true || $alertId < 0)) {
		throw(new InvalidArgumentException("alertId cannot be empty or negative", 405));
	}

	// grab the mySQL connection
	$pdo = connectToEncryptedMySql("/etc/apache2/capstone/invtext.ini");

	// handle all RESTful calls to Notification
	// get some or all Notification
	if($method === "GET") {
		// set an XSRF cookie on GET requests
		setXsrfCookie("/");
		if(empty($botificationId) === false) {
			$reply->data = Notification::getNotificationByNotificationId($pdo, $notificationId);
		} else if(empty($emailStatus) === false) {
			$reply->data = Notification::getNotificationByEmailStatus($pdo, $emailStatus);
		} else if(empty($date) === false) {
			$reply->data = Notification::getNotificationByNotificationDateTime($pdo, $date);
		} else if(empty($alertId) === false) {
			$reply->data = Notification::getNotificationByAlertId($pdo, $alertId);
		} else {
			$reply->data = Notification::getAllNotifications($pdo)->toArray();
		}
		// post to a new Notification
	} else if($method === "POST") {
		// convert POSTed JSON to an object
		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

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