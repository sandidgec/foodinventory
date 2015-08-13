<?php
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
	$method = array_key_exists("HTTPS_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] :
		$_SERVER["REQUEST_METHOD"];

	// sanitize the Id
	$userId = filter_input(INPUT_GET, "userId", FILTER_VALIDATE_INT);
	if(($method === "DELETE" || $method === "PUT") && (empty($userId) === true || $userId < 0)) {
		throw(new InvalidArgumentException("userId cannot be empty or negative", 405));
	}

	// sanitize the Email
	$email = filter_input(INPUT_GET, "email", FILTER_VALIDATE_EMAIL);
	if(($method === "DELETE" || $method === "PUT") && (empty($email) === true)) {
		throw(new InvalidArgumentException("email cannot be empty", 405));
	}

	// grab the mySQL connection
	$pdo = connectToEncryptedMySql("/etc/apache2/capstone/invtext.ini");

	// handle the RESTful calls to user
	// get some or all users
	if($method === "GET") {
		// set an XSRF cookie on GET requests
		setXsrfCookie("/");
		if(empty($userId) === false) {
			$reply->data = User::getUserbyUserId($pdo, $userId);
		} else if(empty($email) === false) {
			$reply->data = User::getUserByEmail($pdo, $email);
		} else{
				$reply->data = User::getALLusers($pdo)->toArray();
			}
		// put to an existing User
	} else if($method === "PUT") {
		// convert PUTed JSON to an object
		verifyXsrf();
		$requestContent = file_get_contents("php://inputs");
		$requestObject = json_decode($requestContent);

		$user = new User($userId, $requestObject->lastName, $requestObject->firstName, $requestObject->root, $requestObject->attention,
			$requestObject->addressLineOne, $requestObject->addressLineTwo, $requestObject->city, $requestObject->state,
			$requestObject->zipCode, $requestObject->email, $requestObject->phoneNumber, $requestObject->hash, $requestObject->salt);
		$user->update($pdo);
		$reply->data = "User Updated Ok";

		// post to a new User
	} else if($method === "POST") {
		// convert POSTed JSON to an object
		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		$user = new User(null, $userId, $requestObject->lastName, $requestObject->firstName, $requestObject->root, $requestObject->attention,
			$requestObject->addressLineOne, $requestObject->addressLineTwo, $requestObject->city, $requestObject->state,
			$requestObject->zipCode, $requestObject->email, $requestObject->phoneNumber, $requestObject->hash, $requestObject->salt);
		$user->insert($pdo);
		$reply->data = "User created OK";
	}
	// create an exception to pass back to the RESTful caller
} 	catch(Exception $exception) {
		$reply->status = $exception->getCode();
		$reply->message = $exception->getMessage();
		unset($reply->data);
}

header("Content-type: application/json");
echo json_encode($reply);



