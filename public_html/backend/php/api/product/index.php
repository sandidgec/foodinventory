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

	// sanitize the productId
	$productId = filter_input(INPUT_GET, "productId", FILTER_VALIDATE_INT);
	if(($method === "DELETE" || $method === "PUT") && (empty($productId) === true || $productId < 0)) {
		throw(new InvalidArgumentException("productId cannot be empty or negative", 405));
	}

	// sanitize the vendorId
	$vendorId = filter_input(INPUT_GET, "vendorId", FILTER_VALIDATE_INT);

	// sanitize the description
	$description = filter_input(INPUT_GET, "description", FILTER_SANITIZE_STRING);

	// sanitize the leadTime
	$leadTime = filter_input(INPUT_GET, "leadTime", FILTER_VALIDATE_INT);

	// sanitize the sku
	$sku = filter_input(INPUT_GET, "sku", FILTER_SANITIZE_STRING);

	// sanitize the title
	$title = filter_input(INPUT_GET, "title", FILTER_SANITIZE_STRING);

	// sanitize the pagination
	$pagination = filter_input(INPUT_GET, "pagination", FILTER_VALIDATE_INT);


	// grab the mySQL connection
	$pdo = connectToEncryptedMySql("/etc/apache2/capstone-mysql/invtext.ini");

	// handle all RESTful calls to Product
	// get some or all Products
	if($method === "GET") {
		// set an XSRF cookie on GET requests
		setXsrfCookie("/");
		if(empty($productId) === false) {
			$reply->data = Product::getProductByProductId($pdo, $productId);
		} else if(empty($vendorId) === false) {
			$reply->data = Product::getProductByVendorId($pdo, $vendorId);
		} else if(empty($description) === false) {
			$reply->data = Product::getProductByDescription($pdo, $description);
		} else if(empty($leadTIme) === false) {
			$reply->data = Product::getProductByLeadTime($pdo, $leadTime);
		} else if(empty($sku) === false) {
			$reply->data = Product::getProductBySku($pdo, $sku);
		} else if(empty($title) === false) {
			$reply->data = Product::getProductByTitle($pdo, $title);
		} else if(empty($pagination) === false) {
			$reply->data = Product::getAllProducts($pdo, $pagination);
		} // post to a new Product
		else if($method === "POST") {
			// convert POSTed JSON to an object
			verifyXsrf();
			$requestContent = file_get_contents("php://input");
			$requestObject = json_decode($requestContent);

			$product = new Product(null, $requestObject->vendorId, $requestObject->description, $requestObject->leadTime, $requestObject->sku, $requestObject->title);
			$product->insert($pdo);
			$reply->data = "Product created OK";
		}
		// put to an existing Product
	} else if($method === "PUT") {
		// convert PUTed JSON to an object
		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		$product = new Product($productId, $requestObject->vendorId, $requestObject->description, $requestObject->leadTime, $requestObject->sku, $requestObject->title);
		$product->update($pdo);
		$reply->data = "Product updated OK";
	} // delete an existing Product
	else if($method === "DELETE") {
		verifyXsrf();
		$product = Product::getProductByProductId($pdo, $productId);
		$product->delete($pdo);
		$reply->data = "Product deleted OK";
	}
// create an exception to pass back to the RESTful caller
} catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
	unset($reply->data);
}

header("Content-type: application/json");
echo json_encode($reply);



