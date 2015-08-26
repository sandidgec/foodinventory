<?php
require_once(dirname(__DIR__) . "/classes/autoload.php");
require_once("xsrf.php");
require_once("/etc/apache2/data-design/encrypted-config.php");

// start the session and create a XSRF token
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

// prepare a default error message
$reply = new stdClass();
$reply->status = 401;
$reply->message = "Username/password incorrect";

try {
	// grab the mySQL connection
	$pdo = connectToEncryptedMySql("/etc/apache2/capstone-mysql/invtext.ini");

	// convert POSTed JSON to an object
	verifyXsrf();
	$requestContent = file_get_contents("php://input");
	$requestObject = json_decode($requestContent);

	// sanitize the email & search by Email
	$email = filter_var($requestObject->email, FILTER_SANITIZE_EMAIL);
	$user = User::getUserByEmail($pdo, $email);

	if($user !== null) {
		$hash = hash_pbkdf2("sha512", $requestObject->password, $user->getSalt(), 262144, 128);
		if($hash === $user->getHash()) {
			$_SESSION["user"] = $user;
			$reply->status = 200;
			$reply->message = "User logged in";
		}
	}

	// create an exception to pass back to the RESTful caller
} catch(Exception $exception) {
	// ignore them - the default error message will take over
}

header("Content-type: application/json");
echo json_encode($reply);
