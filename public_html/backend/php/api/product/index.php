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
	if(($method === "DELETE" || $method === "PUT") && (empty($vendorId) === true || $vendorId < 0)) {
		throw(new InvalidArgumentException("vendorId cannot be empty or negative", 405));
	}

	// sanitize the description
	$description = filter_input(INPUT_GET, "description", FILTER_VALIDATE_INT);
	if(($method === "DELETE" || $method === "PUT") && (empty($description) === true || $description < 0)) {
		throw(new InvalidArgumentException("description cannot be empty or negative", 405));
	}

	// sanitize the sku
	$sku = filter_input(INPUT_GET, "sku", FILTER_VALIDATE_INT);
	if(($method === "DELETE" || $method === "PUT") && (empty($sku) === true || $sku < 0)) {
		throw(new InvalidArgumentException("sku cannot be empty or negative", 405));
	}

	// sanitize the title
	$title = filter_input(INPUT_GET, "title", FILTER_VALIDATE_INT);
	if(($method === "DELETE" || $method === "PUT") && (empty($title) === true || $title < 0)) {
		throw(new InvalidArgumentException("title cannot be empty or negative", 405));
	}

	// sanitize the pagination
	$pagination = filter_input(INPUT_GET, "pagination", FILTER_VALIDATE_INT);
	if(($method === "DELETE" || $method === "PUT") && (empty($productId) === true || $pagination < 0)) {
		throw(new InvalidArgumentException("pagination cannot be empty or negative", 405));
	}


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
			$reply->data = Product::getDescriptionByDescription($pdo, $description);
		} else if(empty($sku) === false) {
			$reply->data = Product::getSkuBySku($pdo, $sku);
		} else if(empty($title) === false) {
	$reply->data = Product::getTitleByTitle($pdo, $title);
		} else if(empty($pagination) === false) {
		$reply->data = Product::getPaginationByPagination($pdo, $pagination);
	}
		// post to a new Product
		else if($method === "POST") {
			// convert POSTed JSON to an object
			verifyXsrf();
			$requestContent = file_get_contents("php://input");
			$requestObject = json_decode($requestContent);

			$product = new Product(null, $requestObject->vendorId, $requestObject->description, $requestObject->sku, $requestObject->title, $requestObject->pagination);
			$product->insert($pdo);
			$reply->data = "Product created OK";
		}
		// put to an existing Product
	} else if($method === "PUT") {
		// convert PUTed JSON to an object
		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		$product = new Product($productId, $requestObject->vendorId, $requestObject->description, $requestObject->sku, $requestObject->title, $requestObject->pagination);
		$product->update($pdo);
		$reply->data = "Product updated OK";
	}
	// delete an existing Product
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

