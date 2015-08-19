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
	 * creating a null Vendor
	 * object for global scope
	 * @var Vendor $vendor
	 **/
	protected $vendor = null;

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
	 * @var guzzle
	 **/
	protected $guzzle = null;



	/**
	 * Set up for Vendor as well as guzzle/cookies
	 **/
	public final function setUp() {
		parent::setUp();

		// create and insert a Vendor id
		$this->vendor = new Vendor(null, "Joe Cool", "joecool@gmail.com", "Joe Cool", 5055555555);
		$this->vendor->insert($this->getPDO());
		// create and insert a GuzzleHttp
		$this->guzzle = new \GuzzleHttp\Client(['cookies' => true]);
	}


	/**
	 * test grabbing a Product by vendorId
	 **/
	public function testGetValidProductByVendorId() {
		// create a new Product
		$newProduct = new Product(null, $this->vendor->getVendorId(), $this->VALID_description,
			$this->VALID_leadTime, $this->VALID_sku, $this->VALID_title);
		$newProduct->insert($this->getPDO());

		// grab the data from guzzle and enforce the status' match our expectations
		$response = $this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/product/?productId=' . $newProduct->getProductId());
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		echo $body . PHP_EOL;
		$product = json_decode($body);
		$this->assertSame(200, $product->status);
	}

	/**
	 * test grabbing a Product by description
	 **/
	public function testGetValidProductByDescription() {
		// create a new Product
		$newProduct = new Product(null, $this->vendor->getVendorId(), $this->VALID_description,
			$this->VALID_leadTime, $this->VALID_sku, $this->VALID_title);
		$newProduct->insert($this->getPDO());

		// grab the data from guzzle and enforce the status' match our expectations
		$response = $this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/product/?productId=' . $newProduct->getProductId());
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		echo $body . PHP_EOL;
		$product = json_decode($body);
		$this->assertSame(200, $product->status);
	}

	/**
	 * test grabbing a Product by invalid description
	 **/
	public function testGetInvalidProductByDescription() {
		// grab the data from guzzle and enforce the status' match our expectations
		$response = $this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/product/?productId=' . InventoryTextTest::INVALID_KEY);
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		$product = json_decode($body);
		$this->assertSame(200, $product->status);
	}


	/**
	 * test grabbing a Product by sku
	 **/
	public function testGetValidProductBySku() {
		// create a new Product
		$newProduct = new Product(null, $this->vendor->getVendorId(), $this->VALID_description,
			$this->VALID_leadTime, $this->VALID_sku, $this->VALID_title);
		$newProduct->insert($this->getPDO());

		// grab the data from guzzle and enforce the status' match our expectations
		$response = $this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/product/?productId=' . $newProduct->getProductId());
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		echo $body . PHP_EOL;
		$product = json_decode($body);
		$this->assertSame(200, $product->status);
	}


		/**
		 * test grabbing a Product by invalid sku
		 **/
		public
		function testGetInvalidProductBySku() {
		// grab the data from guzzle and enforce the status' match our expectations
		$response = $this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/product/?productId=' . InventoryTextTest::INVALID_KEY);
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		$product = json_decode($body);
		$this->assertSame(200, $product->status);
		}

	/**
	 * test grabbing a Product by title
	 **/
	public function testGetValidProductByTitle() {
			// create a new Product
			$newProduct = new Product(null, $this->vendor->getVendorId(), $this->VALID_description,
				$this->VALID_leadTime, $this->VALID_sku, $this->VALID_title);
			$newProduct->insert($this->getPDO());

		// grab the data from guzzle and enforce the status' match our expectations
		$response = $this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/product/?productId=' . $newProduct->getProductId());
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		echo $body . PHP_EOL;
		$product = json_decode($body);
		$this->assertSame(200, $product->status);
	}

	/**
	 * test grabbing a Product by invalid title
	 **/
	public function testGetInvalidProductByTitle() {
		// grab the data from guzzle and enforce the status' match our expectations
		$response = $this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/product/?productId=' . InventoryTextTest::INVALID_KEY);
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
		echo $body . PHP_EOL;
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
		$this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/movement/?page=0');

		$newProduct->insert($this->getPDO());

		// grab the data from guzzle and enforce the status' match our expectations
		$response = $this->guzzle->put('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/product/' . $newProduct->getProductId(), ['headers' => ['X-XSRF-TOKEN' => $this->getXsrfToken()], 'json' => $newProduct]);
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

		// run a get request to establish session tokens
		$this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/movement/?page=0');

		$newProduct->insert($this->getPDO());

		// grab the data from guzzle and enforce the status' match our expectations
		$response = $this->guzzle->put('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/product/' . $newProduct->getProductId(), ['headers' => ['X-XSRF-TOKEN' => $this->getXsrfToken()], 'json' => $newProduct]);
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		echo $body . PHP_EOL;
		$product = json_decode($body);
		$this->assertSame(200, $product->status);
	}


	/**
	 * test deleting a valid Product
	 **/
	public function testDeleteValidProduct() {
		// create a new Product
		$newProduct = new Product(null, $this->vendor->getVendorId(), $this->VALID_description, $this->VALID_leadTime, $this->VALID_sku, $this->VALID_title);

		// grab the data from guzzle and enforce the status' match our expectations
		$this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/product/');
		$response = $this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/product/?productId=' . $newProduct->getProductId(), ['headers' =>
		['X-XSRF-TOKEN' => $this->getXsrfToken()]]);
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		$product = json_decode($body);
		$this->assertSame(200, $product->status);
	}
}





