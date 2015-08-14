<?php
require_once(dirname(dirname(__DIR__)) . "/lib/xsrf.php");
require_once(dirname(dirname(__DIR__)) . "/classes/vendor.php");
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

	// sanitize the vendorId
	$vendorId = filter_input(INPUT_GET, "vendorId", FILTER_VALIDATE_INT);
	if(($method === "DELETE" || $method === "PUT") && (empty($vendorId) === true || $vendorId < 0)) {
		throw(new InvalidArgumentException("vendortId cannot be empty or negative", 405));
	}
	//sanitize the vendor name
	$vendorName = filter_input(INPUT_GET, "vendorName", FILTER_SANITIZE_STRING);

	// grab the mySQL connection
	$pdo = connectToEncryptedMySql("/etc/apache2/capstone/invtext.ini");

	// handle all RESTful calls to Vendor
	// get some or all Vendors
	if($method === "GET") {
		// set an XSRF cookie on GET requests
		setXsrfCookie("/");
		if(empty($vendorId) === false) {
			$reply->data = Vendor::getVendorByVendorId($pdo, $VendorId);
		} else if(empty($vendorName) === false) {
			$reply->data = Vendor::getVendorByVendorName($pdo, $vendorName);
		} else {
			$reply->data = Movement::getAllMovements($pdo)->toArray();
		}
		// post to a new Movement
	} else if($method === "POST") {
		// convert POSTed JSON to an object
		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		$vendor = new Vendor(null, $requestObject->contactName, $requestObject->vendorEmail,
			$requestObject->vendorName, $requestObject->vendorPhoneNumber);
		$vendor->insert($pdo);
		$reply->data = "Vendor created OK";
	}

	// create an exception to pass back to the RESTful caller
} catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
	unset($reply->data);
}

header("Content-type: application/json");
echo json_encode($reply);
