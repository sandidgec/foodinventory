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
	if(($method === "DELETE" || $method === "PUT") && (empty($alertId) === true || $alertId < 0)) {
		throw(new InvalidArgumentException("alertId cannot be empty or negative", 405));
	}

	// sanitize the alertCode
	$alertCode = filter_input(INPUT_GET, "alertCode", FILTER_SANITIZE_STRING);
	if(($method === "DELETE" || $method === "PUT") && (empty($alertCode) === true || $alertCode < 0)) {
		throw(new InvalidArgumentException("alertCode cannot be empty or negative", 405));
	}

	// sanitize the alertFrequency
	$alertFrequency = filter_input(INPUT_GET, "alertFrequency", FILTER_SANITIZE_STRING);
	if(($method === "DELETE" || $method === "PUT") && (empty($alertFrequency) === true || $alertFrequency < 0)) {
		throw(new InvalidArgumentException("alertFrequency cannot be empty or negative", 405));
	}

	// sanitize the alertPoint
	$alertPoint = filter_input(INPUT_GET, "alertPoint", FILTER_SANITIZE_STRING);
	if(($method === "DELETE" || $method === "PUT") && (empty($alertPoint) === true || $alertPoint < 0)) {
		throw(new InvalidArgumentException("alertPoint cannot be empty or negative", 405));
	}

	// sanitize the alertOperator
	$alertOperator = filter_input(INPUT_GET, "alertOperator", FILTER_SANITIZE_STRING);
	if(($method === "DELETE" || $method === "PUT") && (empty($alertOperator) === true || $alertOperator < 0)) {
		throw(new InvalidArgumentException("alertOperator cannot be empty or negative", 405));
	}

	// grab the mySQL connection
	$pdo = connectToEncryptedMySql("/etc/apache2/capstone/invtext.ini");

	// handle all RESTful calls to AlertLevel
	// get some or all AlertLevels
	if($method === "GET") {
		// set an XSRF cookie on GET requests
		setXsrfCookie("/");
		if(empty($alertId) === false) {
			$reply->data = AlertLevel::getAlertLevelByAlertId($pdo, $alertId);
		} else if(empty($alertCode) === false) {
			$reply->data = AlertLevel::getAlertLevelByAlertCode($pdo, $alertCode);
		} else {
			$reply->data = Movement::getAllMovements($pdo)->toArray();
		}
		// post to a new Movement
	} else if($method === "POST") {
		// convert POSTed JSON to an object
		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		$alertLevel = new AlertLevel(null, $requestObject->alertCode, $requestObject->alertFrequency,
											  $requestObject->alertPoint, $requestObject->alertOperator);
		$alertLevel->insert($pdo);
		$reply->data = "AlertLevel created OK";
	}

	// create an exception to pass back to the RESTful caller
} catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
	unset($reply->data);
}

header("Content-type: application/json");
echo json_encode($reply);
