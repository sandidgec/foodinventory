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

	// sanitize the alertId
	$alertId = filter_input(INPUT_GET, "alertId", FILTER_VALIDATE_INT);

	// sanitize the alertCode
	$alertCode = filter_input(INPUT_GET, "alertCode", FILTER_SANITIZE_STRING);

	// sanitize getProducts
//	$getProducts = filter_input(INPUT_GET, "getProducts", FILTER_VALIDATE_BOOLEAN);

	// grab the mySQL connection
	$pdo = connectToEncryptedMySql("/etc/apache2/capstone/invtext.ini");

	// handle all RESTful calls to AlertLevel
	// get some or all AlertLevels
	if($method === "GET") {
		// set an XSRF cookie on GET requests
		setXsrfCookie("/");
		if(empty($locationId) === false) {
//			if($getProducts === true) {
//				$reply->data = AlertLevel::getProductByAlertId($pdo, $alertId);
//			} else {
				$reply->data = AlertLevel::getAlertLevelByAlertId($pdo, $alertId);
//			}
		} else if(empty($alertCode) === false) {
			$reply->data = AlertLevel::getAlertLevelByAlertCode($pdo, $alertCode);
		} else {
			$reply->data = AlertLevel::getAllAlertLevels($pdo);
		}

		// post to a new User
	} else if($method === "POST") {
		// convert POSTed JSON to an object
		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		$alertLevel = new AlertLevel($alertId, $requestObject->alertCode, $requestObject->alertFrequency, $requestObject->alertPoint, $requestObject->alertOperator);
		$alertLevel->insert($pdo);
		$reply->data = "AlertLevel created OK";

		// delete an existing User
	} else if($method === "DELETE") {
		verifyXsrf();

		$alertLevel = AlertLevel::getAlertLevelByAlertId($pdo, $alertId);
		$user->delete($pdo);
		$reply->data = "AlertLevel deleted OK";

		// put to an existing User
	} else if($method === "PUT") {
		// convert PUTed JSON to an object
		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		$alertLevel = new AlertLevel($alertId, $requestObject->alertCode, $requestObject->alertFrequency, $requestObject->alertPoint, $requestObject->alertOperator);
		$alertLevel->update($pdo);
		$reply->data = "AlertLevel updated OK";
	}

	// create an exception to pass back to the RESTful caller
} catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
	unset($reply->data);
}

header("Content-type: application/json");
echo json_encode($reply);
