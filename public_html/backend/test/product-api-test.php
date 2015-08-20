<?php
// grab the project test parameters
require_once("inventorytext.php");

// grab the autoloader for all Composer classes
require_once(dirname(dirname(dirname(__DIR__))) . "/vendor/autoload.php");

// grab the class(s) under scrutiny
require_once(dirname(__DIR__) . "/php/classes/autoload.php");

/**
 * Full PHPUnit test for the Product API
 *
 * This is a complete PHPUnit test of the Product API.
 * It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Product/Index.php
 * @author Marie Vigil <marie@jtdesignsolutions.com>
 **/
class ProductAPITest extends InventoryTextTest {

	/**
	 * valid description to use
	 * @var string $VALID_description
	 **/
	protected $VALID_description = "kids";

	/**
	 * invalid description to use
	 * @var string $INVALID_description
	 **/
	protected $INVALID_description = null;

	/**
	 * valid leadTime to use
	 * @var int $VALID_leadTime
	 **/
	protected $VALID_leadTime = 1;

	/**
	 * invalid leadTime to use
	 * @var int $INVALID_leadTime
	 **/
	protected $INVALID_leadTime = 4294967296;

	/**
	 * valid sku to use
	 * @var string $VALID_sku
	 **/
	protected $VALID_sku = "TGT345";

	/**
	 * invalid sku to use
	 * @var string $INVALID_sku
	 **/
	protected $INVALID_sku = "4294967296";

	/**
	 * valid title to use
	 * @var string $VALID_title
	 **/
	protected $VALID_title = "test";

	/**
	 * invalid title to use
	 * @var string $INVALID_title
	 **/
	protected $INVALID_title = null;

	/**
	 * creating a null Alert Level
	 * object for global scope
	 * @var AlertLevel $alertLevel
	 **/
	protected $alertLevel = null;

	/**
	 * creating a null Location
	 * object for global scope
	 * @var Location $location
	 **/
	protected $location = null;

	/**
	 * creating a null Notification
	 * object for global scope
	 * @var Notification $notification
	 **/
	protected $notification = null;

	/**
	 * creating a null UnitOfMeasure
	 * object for global scope
	 * @var UnitOfMeasure $unitOfMeasure
	 **/
	protected $unitOfMeasure = null;

	/**
	 * creating a null Vendor
	 * object for global scope
	 * @var Vendor $vendor
	 **/
	protected $vendor = null;


	/**
	 * @var guzzle
	 **/
	protected $guzzle = null;



	/**
	 * Set up for Vendor as well as guzzle/cookies
	 **/
	public final function setUp() {
		parent::setUp();

		$vendorId = null;
		$contactName = "Trevor Rigler";
		$vendorEmail = "trier@cnm.edu";
		$vendorName = "TruFork";
		$vendorPhoneNumber = "5053594687";

		$this->vendor = new Vendor($vendorId, $contactName, $vendorEmail, $vendorName, $vendorPhoneNumber);
		$this->vendor->insert($this->getPDO());

		$locationId = null;
		$description = "Front Stock";
		$storageCode = 12;

		$this->location = new Location($locationId, $storageCode, $description);
		$this->location->insert($this->getPDO());

		$unitId = null;
		$unitCode = "pk";
		$quantity = 10.50;

		$this->unitOfMeasure = new UnitOfMeasure($unitId, $unitCode, $quantity);
		$this->unitOfMeasure->insert($this->getPDO());

		$alertCode = "78";
		$alertFrequency = "56";
		$alertPoint = 1.4;
		$alertOperator = "A";

		$this->alertLevel = new AlertLevel(null, $alertCode, $alertFrequency, $alertPoint, $alertOperator);
		$this->alertLevel->insert($this->getPDO());

		$notificationId = null;
		$alertId = $this->alertLevel->getAlertId();
		$emailStatus = false;
		$notificationDateTime = null;
		$notificationHandle = "unit test";
		$notificationContent = "place holder";

		$notificationDateTime = DateTime::createFromFormat("Y-m-d H:i:s", "1985-06-28 04:26:03");

		$this->notification = new Notification($notificationId, $alertId, $emailStatus, $notificationDateTime, $notificationHandle, $notificationContent);
		$this->notification->insert($this->getPDO());

		// create and insert a GuzzleHttp
		$this->guzzle = new \GuzzleHttp\Client(['cookies' => true]);
	}


	/**
	 * test grabbing a Product by vendorId
	 **/
	public function testGetValidProductByVendorId() {
		// create a new Product
		$newProduct = new Product(null, $this->vendor->getVendorId(), $this->VALID_description, $this->VALID_leadTime, $this->VALID_sku, $this->VALID_title);
		$newProduct->insert($this->getPDO());

		// grab the data from guzzle and enforce the status' match our expectations
		$response = $this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/product/?vendorId=' . $newProduct->getVendorId());
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
//		echo $body . PHP_EOL;
		$product = json_decode($body);
		$this->assertSame(200, $product->status);
	}

	/**
	 * test grabbing a Product by description
	 **/
	public function testGetValidProductByDescription() {
		// create a new Product
		$newProduct = new Product(null, $this->vendor->getVendorId(), $this->VALID_description, $this->VALID_leadTime, $this->VALID_sku, $this->VALID_title);
		$newProduct->insert($this->getPDO());

		// grab the data from guzzle and enforce the status' match our expectations
		$response = $this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/product/?description=' . $newProduct->getDescription());
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
//		echo $body . PHP_EOL;
		$product = json_decode($body);
		$this->assertSame(200, $product->status);
	}

	/**
	 * test grabbing a Product by sku
	 **/
	public function testGetValidProductBySku() {
		// create a new Product
		$newProduct = new Product(null, $this->vendor->getVendorId(), $this->VALID_description, $this->VALID_leadTime, $this->VALID_sku, $this->VALID_title);
		$newProduct->insert($this->getPDO());

		// grab the data from guzzle and enforce the status' match our expectations
		$response = $this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/product/?sku=' . $newProduct->getSku());
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
//		echo $body . PHP_EOL;
		$product = json_decode($body);
		$this->assertSame(200, $product->status);
	}

	/**
	 * test grabbing a Product by title
	 **/
	public function testGetValidProductByTitle() {
		// create a new Product
		$newProduct = new Product(null, $this->vendor->getVendorId(), $this->VALID_description, $this->VALID_leadTime, $this->VALID_sku, $this->VALID_title);
		$newProduct->insert($this->getPDO());

		// grab the data from guzzle and enforce the status' match our expectations
		$response = $this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/product/?title=' . $newProduct->getTitle());
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
//		echo $body . PHP_EOL;
		$product = json_decode($body);
		$this->assertSame(200, $product->status);
	}

	/**
 * Test grabbing Valid Location by productId
 **/
	public function testGetValidLocationByProductId() {
		// create a new Product
		$newProduct = new Product(null, $this->vendor->getVendorId(), $this->VALID_description, $this->VALID_leadTime, $this->VALID_sku, $this->VALID_title);
		$newProduct->insert($this->getPDO());

		// create a new ProductLocation

		$quantity = 1.5;

		$newProductLocation = new ProductLocation($this->location->getLocationId(), $newProduct->getProductId(), $this->unitOfMeasure->getUnitId(), $quantity);
		$newProductLocation->insert($this->getPDO());

		// grab the data from guzzle
		$response = $this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/product/?productId=' . $newProduct->getProductId() . "&getLocations=true");
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
//		echo $body . PHP_EOL;
		$product = json_decode($body);
		$this->assertSame(200, $product->status);
	}


	/**
	 * Test grabbing Valid Notifications by productId
	 **/
	public function testGetValidNotificationByProductId() {
		// create a new Product
		$newProduct = new Product(null, $this->vendor->getVendorId(), $this->VALID_description, $this->VALID_leadTime, $this->VALID_sku, $this->VALID_title);
		$newProduct->insert($this->getPDO());

		// create a new ProductAlert and insert to into mySQL
		$productAlert = new ProductAlert( $this->alertLevel->getAlertId(), $newProduct->getProductId(), true);
		$productAlert->insert($this->getPDO());

		// grab the data from guzzle
		$response = $this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/product/?productId=' . $newProduct->getProductId() . "&getNotifications=true");
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		$product = json_decode($body);
		$this->assertSame(200, $product->status);
	}

	/**
	 * Test grabbing Valid UnitOfMeasure by productId
	 **/
	public function testGetValidUnitOfMeasureByProductId() {
		// create a new Product
		$newProduct = new Product(null, $this->vendor->getVendorId(), $this->VALID_description, $this->VALID_leadTime, $this->VALID_sku, $this->VALID_title);
		$newProduct->insert($this->getPDO());

		// create a new ProductLocation

		$quantity = 1.5;

		$newProductLocation = new ProductLocation($this->location->getLocationId(), $newProduct->getProductId(), $this->unitOfMeasure->getUnitId(), $quantity);
		$newProductLocation->insert($this->getPDO());

		// grab the data from guzzle
		$response = $this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/product/?productId=' . $newProduct->getProductId() . "&getUnitOfMeasure=true");
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		$product = json_decode($body);
		$this->assertSame(200, $product->status);
	}


	/**
	 * Test grabbing Valid FinishedProduct by productId
	 **/
	public function testGetValidFinishedProductByProductId() {
		// create a new product and insert to into mySQL
		$finishedProduct1 = new Product(null, $this->vendor->getVendorId(), $this->VALID_description, $this->VALID_leadTime, $this->VALID_sku, $this->VALID_title);
		$finishedProduct1->insert($this->getPDO());

		$description = "Today is Thursday";
		$leadTime = 38;
		$sku = "302840779045";
		$title = "This is a title.";

		$rawMaterial = new Product(null, $this->vendor->getVendorId(), $description, $leadTime, $sku, $title);
		$rawMaterial->insert($this->getPDO());

		$finishedProductId = $finishedProduct1->getProductId();
		$rawMaterialId = $rawMaterial->getProductId();
		$rawQuantity = 56;

		$finishedProduct = new FinishedProduct($finishedProductId, $rawMaterialId, $rawQuantity);
		$finishedProduct->insert($this->getPDO());

		// grab the data from guzzle
		$response = $this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/product/?productId=' . $finishedProduct1->getProductId() . "&getFinishedProducts=true");
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		$product = json_decode($body);
		$this->assertSame(200, $product->status);
	}




	/**
	 * test grabbing a Product by pagination
	 **/
	public function testGetValidProductByPagination() {
			// create a new Product
			$newProduct = new Product(null, $this->vendor->getVendorId(), $this->VALID_description,
				$this->VALID_leadTime, $this->VALID_sku, $this->VALID_title);
			$newProduct->insert($this->getPDO());

		// grab the data from guzzle and enforce the status' match our expectations
		$response = $this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/product/?productId=' . $newProduct->getProductId());
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
//		echo $body . PHP_EOL;
		$product = json_decode($body);
		$this->assertSame(200, $product->status);
	}

	/**
	 * test grabbing a Product by invalid pagination
	 **/
	public function testGetInvalidProductByPagination() {
		// grab the data from guzzle and enforce the status' match our expectations
		$response = $this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/product/?productId=' . InventoryTextTest::INVALID_KEY);
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		$product = json_decode($body);
		$this->assertSame(200, $product->status);
	}

	/**
	 * test ability posting a Product
	 **/
	public function testPostValidProduct() {
		// create a new Product
		$newProduct = new Product(null, $this->vendor->getVendorId(), $this->VALID_description,
			$this->VALID_leadTime, $this->VALID_sku, $this->VALID_title);

		// run a get request to establish session tokens
		$this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/product/');

		// grab the data from guzzle and enforce the status' match our expectations
		$response = $this->guzzle->post('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/product/', ['headers' => ['X-XSRF-TOKEN' => $this->getXsrfToken()], 'json' => $newProduct]);
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		$product = json_decode($body);
		$this->assertSame(200, $product->status);
	}

	/**
	 * test ability putting a Product
	 **/
	public function testPutValidProduct() {
		// create a new Product
		$newProduct = new Product(null, $this->vendor->getVendorId(), $this->VALID_description,
			$this->VALID_leadTime, $this->VALID_sku, $this->VALID_title);
		$newProduct->insert($this->getPDO());


		// run a get request to establish session tokens
		$this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/product/' . $newProduct->getProductId());

		// grab the data from guzzle and enforce the status' match our expectations
		$response = $this->guzzle->put('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/product/' . $newProduct->getProductId(), ['headers' => ['X-XSRF-TOKEN' => $this->getXsrfToken()], 'json' => $newProduct]);
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		$product = json_decode($body);
		$this->assertSame(200, $product->status);
	}


	/**
	 * test deleting a valid Product
	 **/
	public function testDeleteValidProduct() {
		// create a new Product
		$newProduct = new Product(null, $this->vendor->getVendorId(), $this->VALID_description, $this->VALID_leadTime, $this->VALID_sku, $this->VALID_title);
		$newProduct->insert($this->getPDO());


		// grab the data from guzzle and enforce the status' match our expectations
		$this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/product/' . $newProduct->getProductId());
		$response = $this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/product/' . $newProduct->getProductId(), ['headers' =>
		['X-XSRF-TOKEN' => $this->getXsrfToken()]]);
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		$product = json_decode($body);
		$this->assertSame(200, $product->status);
	}
}




