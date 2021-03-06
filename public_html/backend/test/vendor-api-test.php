<?php
// grab the project test parameters
require_once("inventorytext.php");

// grab the autoloader for all Composer classes
require_once(dirname(dirname(dirname(__DIR__))) . "/vendor/autoload.php");

// grab the class(s) under scrutiny
require_once(dirname(__DIR__) . "/php/classes/autoload.php");
/**
 * Full PHPUnit test for the Vendor API
 *
 * This is a complete PHPUnit test of the Vendor API. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Vendor
 * @author James Huber <jhuber8@cnm.edu>
 **/
class VendorAPITest extends InventoryTextTest {
	/**
	 * valid at vendor id to use
	 * @var int $VALID_vendorId
	 **/
	protected $VALID_vendorId = "69";
	/**
	 * invalid vendor id to use
	 * @var int $INVALID_vendorId
	 **/
	protected $INVALID_vendorId = "4294967296";
	/**
	 * valid contact name to use
	 * @var string $VALID_contactName
	 **/
	protected $VALID_contactName = "Topher Sucks";
	/**
	 * valid contact name 2 to use
	 * @var string $VALID_contactName2
	 **/
	protected $VALID_contactName2 = "Charles Sandidge";
	/**
	 * invalid contact name to use
	 * @var string $INVALID_contactName
	 **/
	protected $INVALID_contactName = "-6";
	/**
	 * valid vendor email to use
	 * @var string $VALID_vendorEmail
	 **/
	protected $VALID_vendorEmail = "topersucks@myunit.test";
	/**
	 * invalid vendor email to use
	 * @var int $VALID_emailStatus
	 **/
	protected $INVALID_vendorEmail = "@myunit.test";
	/**
	 * valid vendorName to use
	 * @var string $VALID_vendorName
	 **/
	protected $VALID_vendorName = "php  unit test Co";
	/**
	 * invalid vendor email to use
	 * @var string $INVALID_vendorEmail
	 **/
	protected $INVALID_vendorName = "Bobbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb";
	/**
	 * valid vendor phone number to use
	 * @var string $VALID-vendorPhoneNumber
	 **/
	protected $VALID_vendorPhoneNumber = "5555555555";
	/**
	 * second valid notification to use
	 * @var string $VALID_notificationHandle2
	 **/
	protected $INVALID_vendorPhoneNumber = "555555555555555555555";
	/**
	 * because guzzle
	 **/
	protected $guzzle = null;

	/**
	 * setting shit up to guzzle
	 **/
	public function setUp() {
		parent::setUp();

		$this->guzzle = new \GuzzleHttp\Client(['cookies' => true]);
	}
	/**
	 * Test Deleting a Valid Vendor
	 **/
	public function testDeleteValidVendor() {
		// create a new Vendor
		$newVendor = new  Vendor(null, $this->VALID_contactName, $this->VALID_vendorEmail, $this->VALID_vendorName, $this->VALID_vendorPhoneNumber);
		$newVendor->insert($this->getPDO());

		//run a request to establish session tokens
		$this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/vendor/');

		// grab the data from guzzle and enforce the status' match our expectations
		$response = $this->guzzle->delete('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/vendor/' . $newVendor->getVendorId(),
			['headers' => ['X-XSRF-TOKEN' => $this->getXsrfToken()]]);
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		$vendor = json_decode($body);
		$this->assertSame(200, $vendor->status);
	}
	/**
	 * test grabbing a Vendor by valid vendorId
	 **/
	public function testGetValidVendorByVendorId() {
		// create a new Vendor and insert to into mySQL
		$newVendor = new Vendor(null, $this->VALID_contactName, $this->VALID_vendorEmail, $this->VALID_vendorName, $this->VALID_vendorPhoneNumber);
		$newVendor->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$response = $this->guzzle->get('http://bootcamp-coders.cnm.edu/~invtext/backend/php/api/vendor/?vendorId=' . $newVendor->getVendorId());
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		$vendor = json_decode($body);
		$this->assertSame(200, $vendor->status);
	}
	/**
	 * test grabbing a invalid vendor by vendorId
	 **/
	public function testGetInvalidVendorByVendorId() {
		// grab the data from mySQL and enforce the fields match our expectations
		$response = $this->guzzle->get('http://bootcamp-coders.cnm.edu/~invtext/backend/php/api/vendor/?vendorId=' . InventoryTextTest::INVALID_KEY);
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		$vendor = json_decode($body);
		$this->assertSame(200, $vendor->status);
	}
	/**
	 * test grabbing a valid Vendor by vendor name
	 **/
	public function testGetValidVendorByVendorName() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("vendor");

		// create a new Vendor and insert to into mySQL
		$vendor = new Vendor(null, $this->VALID_contactName, $this->VALID_vendorEmail, $this->VALID_vendorName, $this->VALID_vendorPhoneNumber);
		$vendor->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$response = $this->guzzle->get('http://bootcamp-coders.cnm.edu/~invtext/backend/php/api/vendor/?vendorName=' . $vendor->getVendorName());
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		$object = json_decode($body);
		$this->assertSame(200, $object->status);
	}

	/**
	 * test grabbing a invalid Vendor by vendor name
	 **/
	public function testGetInvalidVendorByVendorName() {
		// create a new Vendor and insert to into mySQL
		$vendor = new Vendor(null, $this->VALID_contactName, $this->VALID_vendorEmail, $this->VALID_vendorName, $this->VALID_vendorPhoneNumber);
		$vendor->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$response = $this->guzzle->get('http://bootcamp-coders.cnm.edu/~invtext/backend/php/api/vendor/?vendorName=' . InventoryTextTest::INVALID_KEY);
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		$vendor = json_decode($body);
		$this->assertSame(200, $vendor->status);
	}
	/**
	* Test Get All Vendors
	**/
	public function testGetAllVendors() {
		// create a new Location
		$newVendor = new Vendor(null, $this->VALID_contactName, $this->VALID_vendorEmail, $this->VALID_vendorName, $this->VALID_vendorPhoneNumber);

		$newVendor->insert($this->getPDO());

		// grab the data from guzzle
		$response = $this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/vendor/');
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		$vendor = json_decode($body);
		$this->assertSame(200, $vendor->status);
	}
	/**
	 * test ability to Post valid vendor
	 **/
	public function testPostValidVendor() {
		// create a new Vendor
		$newVendor = new Vendor(null, $this->VALID_contactName, $this->VALID_vendorEmail, $this->VALID_vendorName, $this->VALID_vendorPhoneNumber);

		// run a get request to establish session tokens
		$this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/vendor/?vendorName=br');

		// grab the data from guzzle and enforce the status' match our expectations
		$response = $this->guzzle->post('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/vendor/',
			['headers' => ['X-XSRF-TOKEN' => $this->getXsrfToken()], 'json' => $newVendor]);
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		$vendor = json_decode($body);
		echo $body.PHP_EOL;
		$this->assertSame(200, $vendor->status);
	}

	/**
	 * test ability to Put valid vendor
	 **/
	public function testPutValidVendor() {
		// create a new vendor
		$newVendor = new Vendor(null, $this->VALID_contactName, $this->VALID_vendorEmail, $this->VALID_vendorName, $this->VALID_vendorPhoneNumber);
		$newVendor->insert($this->getPDO());

		// run a get request to establish session tokens
		$this->guzzle->get('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/vendor/');

		// grab the data from guzzle and enforce the status' match our expectations
		$response = $this->guzzle->put('https://bootcamp-coders.cnm.edu/~invtext/backend/php/api/vendor/' . $newVendor->getVendorId(),
			['headers' =>	['X-XSRF-TOKEN' => $this->getXsrfToken()], 'json' => $newVendor]);
		$this->assertSame($response->getStatusCode(), 200);
		$body = $response->getBody();
		$vendor = json_decode($body);
		echo $body.PHP_EOL;
		$this->assertSame(200, $vendor->status);
	}
}