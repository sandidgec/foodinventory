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
	$emailStatus = filter_input(INPUT_GET,"emailStatus", FILTER_VALIDATE_BOOLEAN);

	//sanitize the date
	$notificationDateTime = filter_input(INPUT_GET, "notificationDateTime", FILTER_VALIDATE_INT);

	// grab the mySQL connection
	$pdo = connectToEncryptedMySql("/etc/apache2/capstone-mysql/invtext.ini");

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
			$reply->data = Notification::getNotificationByNotificationDateTime($pdo, $notificationDateTime);
		} else if(empty($page) === false) {
			$reply->data = Notification::getAllNotifications($pdo, $page)->toArray();
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