<?php
// grab the project test parameters
require_once("inventorytext.php");

// grab the autoloader for all Composer classes
require_once(dirname(dirname(dirname(__DIR__))) . "/vendor/autoload.php");

// grab the class(s) under scrutiny
require_once(dirname(__DIR__) . "/php/classes/autoload.php");

/**
 * Full PHPUnit test for the AlertLevel API
 *
 * This is a complete PHPUnit test of the AlertLevel API.
 * It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see alert-level/index
 * @author Christopher Collopy <ccollopy@cnm.edu>
 **/
class AlertLevelAPITest extends InventoryTextTest {
	/**
	 * valid at alert id to use
	 * @var int $VALID_alertId
	 **/
	protected $VALID_alertId = 69;
	/**
	 * invalid alert id to use
	 * @var int $INVALID_alertId
	 **/
	protected $INVALID_alertId = "ASC";
	/**
	 * valid alert code to use
	 * @var string $VALID_alertCode
	 **/
	protected $VALID_alertCode = "A6";
	/**
	 * invalid alert code to use
	 * @var string $INVALID_alertCode
	 **/
	protected $INVALID_alertCode = 123456;
	/**
	 * valid alert level to use
	 * @var string $VALID_alertLevel
	 **/
	protected $VALID_alertPoint = 100.321;
	/**
	 * invalid alert level to use
	 * @var string $INVALID_alertLevel
	 **/
	protected $INVALID_alertPoint = 100.3211232;
	/**
	 * valid alert frequency to use
	 * @var string $VALID_vendorFrequency
	 **/
	protected $VALID_alertFrequency = "A";
	/**
	 * invalid alert frequency to use
	 * @var string $VALID_alertFrequency
	 **/
	protected $INVALID_alertFrequency = "ABC";
	/**
	 * valid alert operator to use
	 * @var string $VALID_alertOperator
	 **/
	protected $VALID_alertOperator = "a";

	/**
	 * creating a null Product
	 * object for global scope
	 * @var Product $product
	 **/
	protected $product = null;


	/**
	 * Set up for Salt and Hash as well as guzzle/cookies
	 **/
	public function setUp() {
		parent::setUp();

		$this->guzzle = new \GuzzleHttp\Client(['cookies' => true]);

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
	}


	/**
	 * Test Deleting a Valid AlertLevel
	 **/
	public function testDeleteValidAlertLevel() {
		// create a new AlertLevel
		$newAlertLevel = new AlertLevel (null, $this->VALID_alertCode, $this->VALID_alertFrequency, $this->VALID_alertPoint, $this->VALID_alertOperator);
		$newAlertLevel->insert($this->getPDO());

		// run a get request to establish session tokens
		$this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/alert-level/');

		// grab the data from guzzle and enforce the status' match our expectations
		$response = $this->guzzle->delete('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/alert-level/' . $newAlertLevel->getAlertId(),
			['headers' => ['X-XSRF-TOKEN' => $this->getXsrfToken()]]);
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		$alertLevel = json_decode($body);
		$this->assertSame(200, $alertLevel->status);
	}

	/**
	 * Test Getting Valid AlertLevel By AlertId
	 **/
	public function testGetValidAlertLevelByAlertId() {
		// create a new AlertLevel
		$newAlertLevel = new AlertLevel (null, $this->VALID_alertCode, $this->VALID_alertFrequency, $this->VALID_alertPoint, $this->VALID_alertOperator);
		$newAlertLevel->insert($this->getPDO());

		// grab the data from guzzle
		$response = $this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/alert-level/?alertId=' . $newAlertLevel->getAlertId());
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		$alertLevel = json_decode($body);
		$this->assertSame(200, $alertLevel->status);
	}

	/**
	 * Test Getting Invalid AlertLevel By AlertId
	 **/
	public function testGetInvalidAlertLevelByAlertId() {
		// create a new AlertLevel
		$newAlertLevel = new AlertLevel (null, $this->VALID_alertCode, $this->VALID_alertFrequency, $this->VALID_alertPoint, $this->VALID_alertOperator);
		$newAlertLevel->insert($this->getPDO());

		// grab the data from guzzle
		$response = $this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/alert-level/?alertId=' . $this->INVALID_alertId);
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		$alertLevel = json_decode($body);
		$this->assertSame(200, $alertLevel->status);
	}

	/**
	 * Test Getting Valid AlertLevel By AlertCode
	 **/
	public function testGetValidAlertLevelByAlertCode() {
		// create a new AlertLevel
		$newAlertLevel = new AlertLevel (null, $this->VALID_alertCode, $this->VALID_alertFrequency, $this->VALID_alertPoint, $this->VALID_alertOperator);
		$newAlertLevel->insert($this->getPDO());

		// grab the data from guzzle
		$response = $this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/alert-level/?alertCode=' . $newAlertLevel->getAlertCode());
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		$alertLevel = json_decode($body);
		$this->assertSame(200, $alertLevel->status);
	}

	/**
	 * Test Getting Invalid AlertLevel By AlertCode
	 **/
	public function testGetInvalidAlertLevelByAlertCode() {
		// create a new AlertLevel
		$newAlertLevel = new AlertLevel (null, $this->VALID_alertCode, $this->VALID_alertFrequency, $this->VALID_alertPoint, $this->VALID_alertOperator);
		$newAlertLevel->insert($this->getPDO());

		// grab the data from guzzle
		$response = $this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/alert-level/?alertCode=' . $this->INVALID_alertCode);
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		$alertLevel = json_decode($body);
		$this->assertSame(200, $alertLevel->status);
	}

	/**
	 * Test grabbing Valid Product by alertId
	 **/
	public function testGetValidProductByAlertId() {
		// create a new AlertLevel
		$newAlertLevel = new AlertLevel (null, $this->VALID_alertCode, $this->VALID_alertFrequency, $this->VALID_alertPoint, $this->VALID_alertOperator);
		$newAlertLevel->insert($this->getPDO());

		// create a new ProductAlert
		$newProductAlert = new ProductAlert($newAlertLevel->getAlertId(), $this->product->getProductId(), true);
		$newProductAlert->insert($this->getPDO());

		// grab the data from guzzle
		$response = $this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/alert-level/?alertId=' . $newAlertLevel->getAlertId() . "&getProducts=true");
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		$alertLevel = json_decode($body);
		$this->assertSame(200, $alertLevel->status);
	}

	/**
	 * test ability to Post valid AlertLevel
	 **/
	public function testPostValidAlertLevel() {
		// create a new AlertLevel
		$newAlertLevel = new AlertLevel (null, $this->VALID_alertCode, $this->VALID_alertFrequency, $this->VALID_alertPoint, $this->VALID_alertOperator);

		// run a get request to establish session tokens
		$this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/alert-level/?alertCode=br');

		// grab the data from guzzle and enforce the status' match our expectations
		$response = $this->guzzle->post('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/alert-level/',
			['headers' => ['X-XSRF-TOKEN' => $this->getXsrfToken()], 'json' => $newAlertLevel]);
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		$alertLevel = json_decode($body);
		$this->assertSame(200, $alertLevel->status);
	}

	/**
	 * test ability to Put valid AlertLevel
	 **/
	public function testPutValidAlertLevel() {
		// create a new AlertLevel
		$newAlertLevel = new AlertLevel (null, $this->VALID_alertCode, $this->VALID_alertFrequency, $this->VALID_alertPoint, $this->VALID_alertOperator);
		$newAlertLevel->insert($this->getPDO());

		// run a get request to establish session tokens
		$this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/alert-level/');

		// grab the data from guzzle and enforce the status' match our expectations
		$response = $this->guzzle->put('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/alert-level/' . $newAlertLevel->getAlertId(),
			['headers' => ['X-XSRF-TOKEN' => $this->getXsrfToken()], 'json' => $newAlertLevel]);
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		$alertLevel = json_decode($body);
		$this->assertSame(200, $alertLevel->status);
	}
}