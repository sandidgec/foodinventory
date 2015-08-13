<?php
require_once(dirname(__DIR__) . "/foodinventory/backend/php/api/product/index.php");
//require_once(dirname(dirname(dirname(__DIR__))) . "/foodinventory/backend/php/api/product/xsrf.php");
require_once(dirname(dirname(dirname(__DIR__))) . "/foodinventory/backend/php/api/product/.htaccess.php");
//require_once("/etc/apache2/data-design/encrypted-config.php");

// start the session and create a XSRF token
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

// prepare an empty reply
$reply = new stdC();
$reply->status = 200;
$reply->data = null;

try {
	// determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	// sanitize the id
	$productid = filter_input(INPUT_GET, "product id", FILTER_VALIDATE_INT);
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true || $productid < 0)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}

	// grab the mySQL connection
	$pdo = connectToEncryptedMySql("/foodinventory/backend/sql/invtext.sql");

	// handle all RESTful calls toProduct
	// get some or all Products
	if($method === "GET") {
		// set an XSRF cookie on GET requests
		setXsrfCookie("/");
		if(empty($productid) === false) {
			$reply->data = Product::getProductByProductId($pdo, $id);
		} else {
			$reply->data = Product::getAllProdcuts($pdo)->toArray();
		}
		// put to an existing Product
	} else if($method === "PUT") {
		// convert PUTed JSON to an object
		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		$product = new TweetProduct($productid, $requestObject->pagination,  $requestObject->title, $requestObject->vendor, $requestObject->discription);
		$tweet->update($pdo);
		$reply->data = "Tweet updated OK";
	}
	// post to a new Tweet
} else if($method === "POST") {
	// convert POSTed JSON to an object
	verifyXsrf();
	$requestContent = file_get_contents("php://input");
	$requestObject = json_decode($requestContent);

	$tweet = new Tweet(null, $requestObject->profileId, $requestObject->tweetContent, $requestObject->tweetDate);
	$tweet->insert($pdo);
	$reply->data = "Tweet created OK";
}
	// delete an existing Tweet
	} else if($method === "DELETE") {
	verifyXsrf();
	$tweet = Tweet::getTweetByTweetId($pdo, $id);
	$tweet->delete($pdo);
	$reply->data = "Tweet deleted OK";
}
// create an exception to pass back to the RESTful caller
} catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
	unset($reply->data);
}

header("Content-type: application/json");
echo json_encode($reply);