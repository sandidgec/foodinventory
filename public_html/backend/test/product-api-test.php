<?php
// grab the project test parameters
require_once("inventorytext.php");

// grab the autoloader for all Composer classes
require_once(dirname(dirname(dirname(__DIR__))) . "/product/autoload.php");

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
class ProductTest extends InventoryTextTest {
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
	 * valid leadTime2 to use
	 * @var int $VALID_leadTime2
	 **/
	protected $VALID_leadTime2 = 2;

	/**
	 * invalid leadTime to use
	 * @var int $INVALID_leadTime
	 **/
	protected $INVALID_leadTime = 4294967296;

	/**
	 * valid sku to use
	 * @var int $VALID_sku
	 **/
	protected $VALID_sku = "TGT345";

	/**
	 * invalid sku to use
	 * @var int $INVALID_sku
	 **/
	protected $INVALID_sku = 4294967296;

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
	 * creating a null Vendor
	 * object for global scope
	 * @var Vendor $vendor
	 **/
	protected $vendor = null;



	public final function setUp() {
		parent::setUp();


		$this->guzzle = new \GuzzleHttp\Client(['cookies' => true]);
		$this->VALID_description = new Description();

		$userId = null;
		$firstName = "Jim";
		$lastName = "Jim";
		$root = 1;
		$attention = "Urgent: ";
		$addressLineOne = "123 House St.";
		$addressLineTwo = "P.O Box. 9965";
		$city = "Tattoine";
		$state = "AK";
		$zipCode = "52467";
		$email = "jim@naboomail.nb";
		$phoneNumber = "5052253231";
		$salt = bin2hex(openssl_random_pseudo_bytes(32));
		$hash = hash_pbkdf2("sha512","password1234", $salt,262144, 128);

		$this->user = new User($userId, $lastName, $firstName, $root, $attention, $addressLineOne, $addressLineTwo, $city, $state, $zipCode, $email, $phoneNumber, $salt, $hash);
		$this->user->insert($this->getPDO());

		$vendorId = null;
		$contactName = "Trevor Rigler";
		$vendorEmail = "trier@cnm.edu";
		$vendorName = "TruFork";
		$vendorPhoneNumber = "5053594687";

		$vendor = new Vendor($vendorId, $contactName, $vendorEmail, $vendorName, $vendorPhoneNumber);
		$vendor->insert($this->getPDO());

		$productId = null;
		$vendorId = $vendor->getVendorId();
		$description = "A glorius bead to use";
		$leadTime = 10;
		$sku = "TGT354";
		$title = "Bead-Green-Blue-Circular";

		$this->product = new Product($productId, $vendorId, $description, $leadTime, $sku, $title);
		$this->product->insert($this->getPDO());

		$locationId = null;
		$description = "Back Stock";
		$storageCode = 13;

		$this->sku = new Sku($productId, $vendorId, $leadTime, $description, $title);
		$this->sku->insert($this->getPDO());

		$productId = null;
		$vendorId = null;
		$leadTime = null;
		$sku = null;
		$title = null;

		$this->title = new Location($productId, $vendorId, $description, $leadTime, $sku);
		$this->title->insert($this->getPDO());

		$productId = null;
		$vendorId = null;
		$description = null;
		$leadTime = null;
		$sku = null;

		$this->vendorId = new VendorId($productId, $description, $leadTime, $sku, $title);
		$this->vendorId->insert($this->getPDO());
	}

	/**
	 * test grabbing a Product by ProductId
	 **/
	public function testGetValidProductByProductId() {
		// create a new Product
		$newProduct = new Product(null, $this->vendor->getVendorId(), $this->VALID_description,
			$this->VALID_leadTime, $this->VALID_sku, $this->VALID_title);
		$newProduct->insert($this->getPDO());

		// grab the data from guzzle and enforce the status' match our expectations
		$response = $this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/product/?productId=' . $newProduct->getProductId());
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		$product = json_decode($body);
		$this->assertSame(200, $product->status);
	}

	/**
	 * test grabbing a Product by invalid ProductId
	 **/
	public function testGetInvalidProductByProductId() {
		// grab the data from guzzle and enforce the status' match our expectations
		$response = $this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/product/?productId=' . InventoryTextTest::INVALID_KEY);
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		$product = json_decode($body);
		$this->assertSame(200, $product->status);
	}


	/**
	 * test grabbing a Product by description
	 **/
	public function testGetValidProductByDescription() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("product");

		// create a new Product and insert to into mySQL
		$product = new Product(null, $this->vendor->getVendorId(), $this->VALID_description,
			$this->VALID_leadTime, $this->VALID_sku, $this->VALID_title);
		$product->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProducts = Product::getProductByDescription($this->getPDO(), $product->getDescription());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("product"));
		foreach($pdoProducts as $pdoProduct) {
			$this->assertSame($pdoProduct->getVendorId(), $this->vendor->getVendorId());
			$this->assertSame($pdoProduct->getDescription(), $this->VALID_description);
			$this->assertSame($pdoProduct->getLeadTime(), $this->VALID_leadTime);
			$this->assertSame($pdoProduct->getSku(), $this->VALID_sku);
			$this->assertSame($pdoProduct->getTitle(), $this->VALID_title);
		}
	}


	/**
	 * test grabbing a Product by leadTime
	 **/
	public function testGetValidProductByLeadTIme() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("product");

		// create a new Product and insert to into mySQL
		$product = new Product(null, $this->vendor->getVendorId(), $this->VALID_description,
			$this->VALID_leadTime, $this->VALID_sku, $this->VALID_title);
		$product->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProducts = Product::getProductByLeadTime($this->getPDO(), $product->getLeadTime());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("product"));
		foreach($pdoProducts as $pdoProduct) {
			$this->assertSame($pdoProduct->getVendorId(), $this->vendor->getVendorId());
			$this->assertSame($pdoProduct->getDescription(), $this->VALID_description);
			$this->assertSame($pdoProduct->getLeadTime(), $this->VALID_leadTime);
			$this->assertSame($pdoProduct->getSku(), $this->VALID_sku);
			$this->assertSame($pdoProduct->getTitle(), $this->VALID_title);
		}
	}


	/**
	 * test grabbing a Product by sku
	 **/
	public function testGetValidProductBySku() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("product");

		// create a new Product and insert to into mySQL
		$product = new Product(null, $this->vendor->getVendorId(), $this->VALID_description,
			$this->VALID_leadTime, $this->VALID_sku, $this->VALID_title);
		$product->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProducts = Product::getProductBySku($this->getPDO(), $product->getSku());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("product"));
		foreach($pdoProducts as $pdoProduct) {
			$this->assertSame($pdoProduct->getVendorId(), $this->vendor->getVendorId());
			$this->assertSame($pdoProduct->getDescription(), $this->VALID_description);
			$this->assertSame($pdoProduct->getLeadTime(), $this->VALID_leadTime);
			$this->assertSame($pdoProduct->getSku(), $this->VALID_sku);
			$this->assertSame($pdoProduct->getTitle(), $this->VALID_title);
		}
	}


	/**
	 * test grabbing a Product by title
	 **/
	public function testGetValidProductByTitle() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("product");

		// create a new Product and insert to into mySQL
		$product = new Product(null, $this->vendor->getVendorId(), $this->VALID_description,
			$this->VALID_leadTime, $this->VALID_sku, $this->VALID_title);
		$product->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoProducts = Product::getProductByTitle($this->getPDO(), $product->getTitle());
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("product"));
		foreach($pdoProducts as $pdoProduct) {
			$this->assertSame($pdoProduct->getVendorId(), $this->vendor->getVendorId());
			$this->assertSame($pdoProduct->getDescription(), $this->VALID_description);
			$this->assertSame($pdoProduct->getLeadTime(), $this->VALID_leadTime);
			$this->assertSame($pdoProduct->getSku(), $this->VALID_sku);
			$this->assertSame($pdoProduct->getTitle(), $this->VALID_title);
		}
	}

	/**
	 * test deleting a Product
	 **/
	public function testDeleteValidProduct() {
		// create a new Product
		$newProduct = new Product(null, $this->vendor->getVendorId(), $this->VALID_description, $this->VALID_leadTime, $this->VALID_sku, $this->VALID_title);

		// grab the data from guzzle and enforce the status' match our expectations
		$response = $this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/product/?productId=' . $newProduct->getProductId());
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		$product = json_decode($body);
		$this->assertSame(200, $product->status);

		// delete Product from mySQL
		$product->delete($this->getPDO());
	}
}



