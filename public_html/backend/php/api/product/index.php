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

	// sanitize getLocations
	$getLocations = filter_input(INPUT_GET, "getLocations", FILTER_VALIDATE_BOOLEAN);

	// sanitize getNotifications
	$getNotifications = filter_input(INPUT_GET, "getNotifications", FILTER_VALIDATE_BOOLEAN);

	// sanitize getUnitOfMeasures
	$getUnitOfMeasures = filter_input(INPUT_GET, "getUnitOfMeasures", FILTER_VALIDATE_BOOLEAN);

	// sanitize getFinishedProducts
	$getFinishedProducts = filter_input(INPUT_GET, "getFinishedProducts", FILTER_VALIDATE_BOOLEAN);

	// sanitize the page
	$page = filter_input(INPUT_GET, "page", FILTER_VALIDATE_INT);


	// grab the mySQL connection
	$pdo = connectToEncryptedMySql("/etc/apache2/capstone-mysql/invtext.ini");

	// handle all RESTful calls to Product
	// get some or all Products
	if($method === "GET") {
		// set an XSRF cookie on GET requests
		setXsrfCookie("/");
		if(empty($productId) === false) {
			if($getLocations === true) {
				$reply->data = Product::getLocationByProductId($pdo, $productId);
			} else if($getNotifications) {
				$reply->data = Product::getNotificationByProductId($pdo, $productId);
			} else if($getUnitOfMeasures) {
				$reply->data = Product::getUnitOfMeasureByProductId($pdo, $productId);
			} else if($getFinishedProducts) {
				$reply->data = Product::getFinishedProductByProductId($pdo, $productId);
			} else {
				$product = Product::getProductByProductId($pdo, $productId);
				$quantityOnHand = $product->getQuantityOnHand($pdo);
				$flatObject = json_decode(json_encode($product));
				$flatObject->quantityOnHand = $quantityOnHand;
				$reply->data = $flatObject;
			}
		} else if(empty($vendorId) === false) {
			$reply->data = Product::getProductByVendorId($pdo, $vendorId);
		} else if(empty($description) === false) {
			$reply->data = Product::getProductByDescription($pdo, $description);
		} else if(empty($leadTIme) === false) {
			$reply->data = Product::getProductByLeadTime($pdo, $leadTime);
		} else if(empty($sku) === false) {
			$reply->data = Product::getProductBySku($pdo, $sku);
		} else if(empty($title) === false) {
			$reply->data = Product::getProductByTitle($pdo, $title)->toArray();
		} else if(is_int($page) === true && $page >= 0) {
			$allProducts = Product::getAllProducts($pdo, $page);
			$replyData = [];
			foreach($allProducts as $index => $product) {
				$replyData[$index] = json_decode(json_encode($product));
				$replyData[$index]->quantityOnHand = $product->getQuantityOnHand($pdo);
			}
			$reply->data = $replyData;
		} else {
			throw(new InvalidArgumentException("no parameters given", 405));
		} // post to a new Product
	} else if($method === "POST") {
		// convert POSTed JSON to an object
		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		$product = new Product(null, $requestObject->vendorId, $requestObject->description, $requestObject->leadTime, $requestObject->sku, $requestObject->title);
		$product->insert($pdo);
		unset($reply->data);
		$reply->productId = $product->getProductId();
		$reply->message = "Product created OK";
		// put to an existing Product
	} else if($method === "PUT") {
		// convert PUTed JSON to an object
		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		$product = new Product($productId, $requestObject->vendorId, $requestObject->description, $requestObject->leadTime, $requestObject->sku, $requestObject->title);
		$product->update($pdo);
		$reply->data = "Product updated OK";
		// delete an existing Product
	} else if($method === "DELETE") {
		verifyXsrf();
		$productAlerts = ProductAlert::getProductAlertByProductId($pdo, $productId);
		foreach($productAlerts as $productAlert) {
			$productAlert->delete($pdo);
		}
		$finishedProducts = FinishedProduct::getFinishedProductByFinishedProductId($pdo, $productId);
		foreach($finishedProducts as $finishedProduct) {
			$finishedProduct->delete($pdo);
		}
		$productLocations = ProductLocation::getProductLocationByProductId($pdo, $productId);
		foreach($productLocations as $productLocation) {
			$productLocation->delete($pdo);
		}
		$movements = Movement::getMovementByProductId($pdo, $productId);
		foreach($movements as $movement) {
			$movement->delete($pdo);
		}
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



