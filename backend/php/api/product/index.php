<?php
require_once(dirname(__DIR__) . "/backend/php/api/product/index.php");
require_once(dirname(__DIR__) . "/backend/php/lib/xsrf.php");
require_once((dirname(__DIR__) . "/backend/php/api/product/.htaccess.php");
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

	// sanitize the productId
	$productId = filter_input(INPUT_GET, "productId", FILTER_VALIDATE_INT);
	if(($method === "DELETE" || $method === "PUT") && (empty($productId) === true || $productId < 0)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}

	// sanitize the vendorId
	$vendorId = filter_input(INPUT_GET, "vendorId", FILTER_VALIDATE_INT);
	if(($method === "DELETE" || $method === "PUT") && (empty($vendorId) === true || $vendorId < 0)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}

	// sanitize the description
	$description = filter_input(INPUT_GET, "descriptionId", FILTER_VALIDATE_INT);
	if(($method === "DELETE" || $method === "PUT") && (empty($description) === true || $description < 0)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}

	// sanitize the title
	$title = filter_input(INPUT_GET, "title", FILTER_VALIDATE_INT);
	if(($method === "DELETE" || $method === "PUT") && (empty($title) === true || $title < 0)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}

	// grab the mySQL connection
	$pdo = connectToEncryptedMySql("/etc/apache2/capstone/invtext.ini");

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
		}
		// put to an existing Product
	} else if($method === "PUT") {
		// convert PUTed JSON to an object
		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		$product = new Products( $requestObject->productId, $requestObject->vendorId,$requestObject->description, $requestObject->sku, $requestObject->title);
		$product->update($pdo);
		$reply->data = "Product updated OK";
	}
	// post to a new Product
	else if($method === "POST") {
	// convert POSTed JSON to an object
	verifyXsrf();
	$requestContent = file_get_contents("php://input");
	$requestObject = json_decode($requestContent);

	$product = new Product(null, $requestObject->productId, $requestObject->pagination,  $requestObject->title, $requestObject->vendor, $requestObject->discription);
	$product->insert($pdo);
	$reply->data = "Product created OK";
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



/*
JsonSerializable {
/* Methods */
/* abstract public mixed jsonSerialize ( void )
}
*/