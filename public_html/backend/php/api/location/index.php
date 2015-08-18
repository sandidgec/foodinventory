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
	$method = array_key_exists("HTTPS_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];


	// sanitize the locationId
	$locationId = filter_input(INPUT_GET, "locationId", FILTER_VALIDATE_INT);

	// sanitize the storageCode
	$storageCode = filter_input(INPUT_GET, "storageCode", FILTER_SANITIZE_STRING);

	// grab the mySQL connection
	$pdo = connectToEncryptedMySql("/etc/apache2/capstone-mysql/invtext.ini");

	// handle the RESTful calls to location
	// get some or all locations
	if($method === "GET") {
		// set an XSRF cookie on GET requests
		setXsrfCookie("/");
		if(empty($locationId) === false) {
			$reply->data = User::getLocationByLocationId($pdo, $locationId);
		} else if(empty($email) === false) {
			$reply->data = User::getLocationByStorageCode($pdo, $storageCode);
		} else{
			$reply->data = User::getALLLocations($pdo);
		}

		// post to a new Location
	} else if($method === "POST") {
		// convert POSTed JSON to an object
		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		$location = new Location( $locationId, $requestObject->storageCode, $requestObject->description);
		$location->insert($pdo);
		$reply->data = "Location created OK";


		// delete an existing Location
	} else if($method === "DELETE") {
		verifyXsrf();
		$location = Location::getLocationByLocationid($pdo, $locationId);
		$location->delete($pdo);
		$reply->data = "Location deleted OK";

	// put to an existing Location
	} else if($method === "PUT") {
		// convert PUTed JSON to an object
		verifyXsrf();
		$requestContent = file_get_contents("php://inputs");
		$requestObject = json_decode($requestContent);

		$location = new Location($locationId, $requestObject->storageCode, $requestObject->description);
		$location->update($pdo);
		$reply->data = "Location Updated Ok";
	}

// create an exception to pass back to the RESTful caller
} 	catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
	unset($reply->data);
}

header("Content-type: application/json");
echo json_encode($reply);